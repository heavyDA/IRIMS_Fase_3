<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Exports\Risk\WorksheetExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetIncident;
use App\Services\PositionService;
use App\Services\RoleService;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class RiskProfileController extends Controller
{
    public function __construct(
        private RoleService $roleService,
        private PositionService $positionService
    ) {}

    public function index()
    {
        if (request()->ajax()) {
            $unit = $this->roleService->getCurrentUnit();
            if (request('unit')) {
                $unit = $this->positionService->getUnitBelow(
                    $unit?->sub_unit_code,
                    request('unit'),
                    $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                ) ?: $unit;
            }

            $worksheets = Worksheet::assessmentQuery()
                ->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit->sub_unit_code,
                        $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                    )
                )
                ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                ->when(session()->get('current_role')?->name == 'risk admin', fn($q) => $q->where('w.created_by', auth()->user()->employee_id))
                ->when(
                    request('document_status'),
                    function ($q) {
                        if (in_array(request('document_status'), ['draft', 'approved'])) {
                            return $q->whereStatus(request('document_status'));
                        }

                        return $q->whereNotIn('status', ['draft', 'approved']);
                    }
                )
                ->whereYear('w.created_at', request('year', date('Y')));

            return DataTables::query($worksheets)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('w.status', '%' . $value . '%')
                                ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                                ->orWhereLike('w.target_body', '%' . $value . '%')
                                ->orWhereLike('wi.risk_chronology_body', '%' . $value . '%')
                                ->orWhereLike('winc.risk_cause_body', '%' . $value . '%')
                                ->orWhereLike('wi.risk_impact_body', '%' . $value . '%')
                                ->orWhereLike('wi.inherent_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.inherent_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_1_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_2_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_3_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_4_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_1_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_2_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_3_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_4_risk_scale', '%' . $value . '%')
                        );
                    }
                })
                ->editColumn('status', function ($incident) {
                    $status = DocumentStatus::tryFrom($incident->status);
                    $class = $status->color();
                    $worksheet_number = $incident->worksheet_number;
                    $route = route('risk.worksheet.show', Crypt::encryptString($incident->worksheet_id));

                    return view('risk.assessment._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
                })
                ->orderColumn('worksheet_number', 'w.worksheet_number $1')
                ->orderColumn('status', 'w.status $1')
                ->orderColumn('sub_unit_name', 'w.sub_unit_name $1')
                ->orderColumn('target_body', 'w.target_body $1')
                ->orderColumn('risk_chronology_body', 'wi.risk_chronology_body $1')
                ->orderColumn('risk_cause_body', 'winc.risk_cause_body $1')
                ->orderColumn('risk_impact_body', 'wi.risk_impact_body $1')
                ->orderColumn('inherent_risk_level', 'wi.inherent_risk_level $1')
                ->orderColumn('inherent_risk_scale', 'wi.inherent_risk_scale $1')
                ->orderColumn('residual_1_risk_level', 'wi.residual_1_risk_level $1')
                ->orderColumn('residual_2_risk_level', 'wi.residual_2_risk_level $1')
                ->orderColumn('residual_3_risk_level', 'wi.residual_3_risk_level $1')
                ->orderColumn('residual_4_risk_level', 'wi.residual_4_risk_level $1')
                ->orderColumn('residual_1_risk_scale', 'wi.residual_1_risk_scale $1')
                ->orderColumn('residual_2_risk_scale', 'wi.residual_2_risk_scale $1')
                ->orderColumn('residual_3_risk_scale', 'wi.residual_3_risk_scale $1')
                ->orderColumn('residual_4_risk_scale', 'wi.residual_4_risk_scale $1')
                ->orderColumn('created_at', 'w.created_at $1')
                ->rawColumns(['status'])
                ->make(true);
        }

        $title = 'Risk Profile';
        return view('report.risk_profile.index', compact('title'));
    }

    public function export()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }

        $incidents = WorksheetIncident::incident_query()
            ->withExpression(
                'position_hierarchy',
                Position::hierarchyQuery(
                    $unit->sub_unit_code,
                    $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                )
            )
            ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'worksheet.sub_unit_code')
            ->when(request('year'), fn($q) => $q->whereYear('worksheet.created_at', request('year')))
            ->when(
                request('document_status'),
                function ($q) {
                    if (in_array(request('document_status'), ['draft', 'approved'])) {
                        return $q->whereStatus(request('document_status'));
                    }

                    return $q->whereNotIn('status', ['draft', 'approved']);
                }
            )
            ->when(
                request('search'),
                fn($q) => $q->where(
                    fn($q) => $q
                        ->orWhereLike('worksheet.worksheet_number', '%' . request('search') . '%')
                        ->orWhereLike('worksheet.status', '%' . request('search') . '%')
                        ->orWhereLike('worksheet.sub_unit_name', '%' . request('search') . '%')
                        ->orWhereLike('worksheet.target_body', '%' . request('search') . '%')
                        ->orWhereLike('identification.risk_chronology_body', '%' . request('search') . '%')
                        ->orWhereLike('incident.risk_cause_body', '%' . request('search') . '%')
                        ->orWhereLike('identification.risk_impact_body', '%' . request('search') . '%')
                        ->orWhereLike('identification.inherent_risk_level', '%' . request('search') . '%')
                        ->orWhereLike('identification.inherent_risk_scale', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_1_risk_level', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_2_risk_level', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_3_risk_level', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_4_risk_level', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_1_risk_scale', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_2_risk_scale', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_3_risk_scale', '%' . request('search') . '%')
                        ->orWhereLike('identification.residual_4_risk_scale', '%' . request('search') . '%')
                )
            )
            ->get();

        $worksheets = Worksheet::with([
            'strategies',
            'incidents.kri_unit',
            'incidents.mitigations',
            'incidents.mitigations.risk_treatment_option',
            'incidents.mitigations.risk_treatment_type',
            'incidents.mitigations.rkap_program_type',
        ])
            ->whereIn('id', $incidents->pluck('worksheet_id'))
            ->simplePaginate(request('per_page', 10));

        $worksheets = collect($worksheets->items());
        $identifications = WorksheetIdentification::identification_query()->whereIn('worksheet_id', $worksheets->pluck('id'))->get();
        $worksheets = $worksheets->map(function ($worksheet) use ($identifications) {
            $worksheet->identification = $identifications->firstWhere('worksheet_id', $worksheet->id);
            return $worksheet;
        });

        $year = $request->year ?? Date('Y');
        $date = now()->translatedFormat('j F Y');

        return Excel::download(new WorksheetExport($worksheets), "Laporan {$date} - Profil Risiko {$year}.xlsx");
    }
}
