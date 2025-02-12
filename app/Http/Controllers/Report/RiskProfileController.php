<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Exports\Risk\WorksheetExport;
use App\Http\Controllers\Controller;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetIncident;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class RiskProfileController extends Controller
{
    public function index()
    {
        $role = session()->get('current_role') ?? auth()->user()->roles()->first();
        if (request()->ajax()) {
            if (Role::hasLookUpUnitHierarchy()) {
                $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
            } else {
                $unit = Role::getDefaultSubUnit();
            }

            $incidents = WorksheetIncident::incident_query()
                ->where(function($q) use($unit, $role) {
                    $q->whereLike('worksheet.sub_unit_code', $unit)
                    ->orWhereLike('worksheet.sub_unit_code', str_replace('.%', '', $unit));
                })
                ->when(request('year'), fn($q) => $q->whereYear('worksheet.created_at', request('year')))
                ->when(
                    request('document_status'),
                    function ($q) {
                        if (in_array(request('document_status'), ['draft', 'approved'])) {
                            return $q->whereStatus(request('document_status'));
                        }

                        return $q->whereNotIn('status', ['draft', 'approved']);
                    }
                );

            return DataTables::query($incidents)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->orWhereLike('worksheet.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('worksheet.status', '%' . $value . '%')
                                ->orWhereLike('worksheet.sub_unit_name', '%' . $value . '%')
                                ->orWhereLike('worksheet.target_body', '%' . $value . '%')
                                ->orWhereLike('identification.risk_chronology_body', '%' . $value . '%')
                                ->orWhereLike('incident.risk_cause_body', '%' . $value . '%')
                                ->orWhereLike('identification.risk_impact_body', '%' . $value . '%')
                                ->orWhereLike('identification.inherent_risk_level', '%' . $value . '%')
                                ->orWhereLike('identification.inherent_risk_scale', '%' . $value . '%')
                                ->orWhereLike('identification.residual_1_risk_level', '%' . $value . '%')
                                ->orWhereLike('identification.residual_2_risk_level', '%' . $value . '%')
                                ->orWhereLike('identification.residual_3_risk_level', '%' . $value . '%')
                                ->orWhereLike('identification.residual_4_risk_level', '%' . $value . '%')
                                ->orWhereLike('identification.residual_1_risk_scale', '%' . $value . '%')
                                ->orWhereLike('identification.residual_2_risk_scale', '%' . $value . '%')
                                ->orWhereLike('identification.residual_3_risk_scale', '%' . $value . '%')
                                ->orWhereLike('identification.residual_4_risk_scale', '%' . $value . '%')
                        );
                    }
                })
                ->editColumn('status', function ($incident) {
                    $status = DocumentStatus::tryFrom($incident->status);
                    $class = $status->color();
                    $worksheet_number = $incident->worksheet_number;
                    $route = route('risk.worksheet.show', Crypt::encryptString($incident->worksheet_id));

                    return view('report.risk_profile._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $title = 'Risk Profile';
        return view('report.risk_profile.index', compact('title'));
    }

    public function export()
    {
        $role = session()->get('current_role') ?? auth()->user()->roles()->first();
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }


        $incidents = WorksheetIncident::incident_query()
            ->where(function($q) use($unit, $role) {
                $q->whereLike('worksheet.sub_unit_code', $unit)
                ->orWhereLike('worksheet.sub_unit_code', str_replace('.%', '', $unit));
            })
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
