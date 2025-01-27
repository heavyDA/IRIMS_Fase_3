<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Exports\Risk\MonitoringActualizationExport;
use App\Exports\Risk\MonitoringExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Official;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetMitigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RiskMonitoringController extends Controller
{
    public function index()
    {
        $title = 'Risk Monitoring';

        if (request()->ajax()) {
            $unit = Role::getDefaultSubUnit();
            $worksheets = Worksheet::latest_monitoring_with_mitigation_query()
                ->where('worksheet_year', request('year', date('Y')))
                ->when(request('document_status'), fn($q) => $q->where('w.status_monitoring', request('document_status')))
                ->whereLike('w.sub_unit_code', request('unit', $unit));

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
                ->rawColumns(['status_monitoring'])
                ->make(true);
        }

        return view('report.risk_monitoring.index', compact('title'));
    }

    public function export()
    {
        $unit = Role::getDefaultSubUnit();
        $worksheets = Worksheet::latest_monitoring_with_mitigation_query()
            ->whereLike('sub_unit_code', request('unit', $unit))
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
                'residuals.impact_scale',
                'residuals.impact_probability_scale',
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

        return Excel::download(new MonitoringExport($worksheets), 'test.xlsx');
    }
}
