<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Exports\Risk\MonitoringExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Services\PositionService;
use App\Services\RoleService;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RiskMonitoringController extends Controller
{
    public function __construct(
        private RoleService $roleService,
        private PositionService $positionService
    ) {}

    public function index()
    {
        $title = 'Risk Monitoring';

        if (request()->ajax()) {
            $unit = $this->roleService->getCurrentUnit();
            if (request('unit')) {
                $unit = $this->positionService->getUnitBelow(
                    $unit?->sub_unit_code,
                    request('unit'),
                    $this->roleService->isRiskOwner()
                ) ?: $unit;
            }

            $worksheets = Worksheet::latestMonitoringWithMitigationQuery()
                ->when(
                    !$this->roleService->isRiskAdmin(),
                    fn($q) => $q
                        ->withExpression(
                            'position_hierarchy',
                            Position::hierarchyQuery(
                                $unit?->sub_unit_code,
                                $this->roleService->isRiskOwner()
                            )
                        )
                        ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                )
                ->when(
                    $this->roleService->isRiskAdmin(),
                    fn($q) => $q
                        ->where('w.sub_unit_code', $unit?->sub_unit_code)
                        ->where('w.created_by', auth()->user()->employee_id)
                )
                ->when(request('document_status'), fn($q) => $q->where('w.status_monitoring', request('document_status')))
                ->where('worksheet_year', request('year', date('Y')));

            return DataTables::query($worksheets)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('w.status_monitoring', '%' . $value . '%')
                                ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                                ->orWhereLike('w.target_body', '%' . $value . '%')
                                ->orWhereLike('w.risk_chronology_body', '%' . $value . '%')
                                ->orWhereLike('wmit.mitigation_plan', '%' . $value . '%')
                                ->orWhereLike('ma.actualization_plan_output', '%' . $value . '%')
                                ->orWhereLike('w.inherent_risk_level', '%' . $value . '%')
                                ->orWhereLike('w.inherent_risk_scale', '%' . $value . '%')
                                ->orWhereLike('ma.quarter', '%' . $value . '%')
                                ->orWhereLike('mr.risk_level', '%' . $value . '%')
                                ->orWhereLike('mr.risk_scale', '%' . $value . '%')
                        );
                    }
                })
                ->editColumn('status_monitoring', function ($worksheet) {
                    $key = $worksheet->worksheet_id;
                    $status = DocumentStatus::tryFrom($worksheet->status_monitoring);
                    $class = $status->color();
                    $worksheet_number = $worksheet->worksheet_number;
                    $route = route('risk.monitoring.show', Crypt::encryptString($key));

                    return view('risk.monitoring._table_status', compact('status', 'class', 'key', 'worksheet_number', 'route'))->render();
                })
                ->orderColumn('worksheet_number', 'w.worksheet_number $1')
                ->orderColumn('status_monitoring', 'w.status_monitoring $1')
                ->orderColumn('target_body', 'w.target_body $1')
                ->orderColumn('risk_chronology_body', 'w.risk_chronology_body $1')
                ->orderColumn('mitigation_plan', 'wmit.mitigation_plan $1')
                ->orderColumn('actualization_plan_output', 'ma.actualization_plan_output $1')
                ->orderColumn('inherent_risk_level', 'w.inherent_risk_level $1')
                ->orderColumn('inherent_risk_scale', 'w.inherent_risk_scale $1')
                ->orderColumn('residual_risk_level', 'mr.risk_level $1')
                ->orderColumn('residual_risk_scale', 'mr.risk_scale $1')
                ->orderColumn('created_at', 'lm.created_at $1')
                ->rawColumns(['status_monitoring'])
                ->make(true);
        }

        return view('report.risk_monitoring.index', compact('title'));
    }

    public function export()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner()
            ) ?: $unit;
        }

        $worksheets = Worksheet::latestMonitoringWithMitigationQuery()
            ->withExpression(
                'position_hierarchy',
                Position::hierarchyQuery(
                    $unit?->sub_unit_code,
                    $this->roleService->isRiskOwner()
                )
            )
            ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            ->when(request('document_status'), fn($q) => $q->where('w.status_monitoring', request('document_status')))
            ->where('w.worksheet_year', request('year', date('Y')))
            ->when(
                request('search'),
                function ($query) {
                    $query->where(
                        fn($query) => $query->orWhereLike('w.worksheet_number', '%' . request('search') . '%')
                            ->orWhereLike('w.status_monitoring', '%' . request('search') . '%')
                            ->orWhereLike('w.sub_unit_name', '%' . request('search') . '%')
                            ->orWhereLike('w.target_body', '%' . request('search') . '%')
                            ->orWhereLike('w.risk_chronology_body', '%' . request('search') . '%')
                            ->orWhereLike('wmit.mitigation_plan', '%' . request('search') . '%')
                            ->orWhereLike('ma.actualization_plan_output', '%' . request('search') . '%')
                            ->orWhereLike('w.inherent_risk_level', '%' . request('search') . '%')
                            ->orWhereLike('w.inherent_risk_scale', '%' . request('search') . '%')
                            ->orWhereLike('ma.quarter', '%' . request('search') . '%')
                            ->orWhereLike('mr.risk_level', '%' . request('search') . '%')
                            ->orWhereLike('mr.risk_scale', '%' . request('search') . '%')
                    );
                }
            )
            ->get();

        $worksheets = Worksheet::with([
            'monitorings' => fn($q) => $q->with(
                'alteration',
                'actualizations',
                'actualizations.mitigation.incident',
                'incident',
                'residual.impact_scale',
                'residual.impact_probability_scale',
            )->oldest('period_date'),
        ])
            ->whereIn('id', $worksheets->pluck('worksheet_id'))
            ->simplePaginate(request('per_page', 10));

        $worksheets = collect($worksheets->items());
        $identifications = WorksheetIdentification::identification_query()->whereIn('worksheet_id', $worksheets->pluck('id'))->get();
        $worksheets = $worksheets->map(function ($worksheet) use ($identifications) {
            $worksheet->identification = $identifications->firstWhere('worksheet_id', $worksheet->id);
            return $worksheet;
        });

        $year = $request->year ?? Date('Y');
        $date = now()->translatedFormat('j F Y');

        return Excel::download(new MonitoringExport($worksheets), "Laporan {$date} - Monitoring dan Evaluasi {$year}.xlsx");
    }
}
