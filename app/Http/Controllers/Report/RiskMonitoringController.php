<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Exports\Risk\MonitoringActualizationExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Official;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetMitigation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RiskMonitoringController extends Controller
{
    public function index()
    {
        $title = 'Risk Monitoring';

        if (request()->ajax()) {
            if (Role::hasLookUpUnitHierarchy()) {
                $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
            } else {
                $unit = Role::getDefaultSubUnit();
            }

            $mitigations = WorksheetMitigation::with([
                'incident',
                'worksheet.identification',
                'monitoring_actualization',
                'monitoring_residual',
            ])
                ->whereHas(
                    'worksheet',
                    fn($q) => $q
                        ->where('sub_unit_code', 'like', $unit)
                        ->where('status', DocumentStatus::APPROVED->value)
                        ->when(
                            request('document_status'),
                            function ($q) {
                                if (in_array(request('document_status'), ['on monitoring', 'on progress monitoring'])) {
                                    return $q->whereStatusMonitoring(request('document_status'));
                                }

                                return $q->whereNotIn('status_monitoring', ['on monitoring', 'on progress monitoring']);
                            }
                        )
                );

            return DataTables::eloquent($mitigations)
                ->editColumn('status_monitoring', function ($mitigation) {
                    $status = DocumentStatus::tryFrom($mitigation->worksheet->status_monitoring);
                    $class = $status->color();
                    $worksheet_number = $mitigation->worksheet->worksheet_number;
                    $route = route('risk.monitoring.show', $mitigation->worksheet->getEncryptedId());
                    $key = $mitigation->worksheet->id;

                    return view('risk.monitoring._table_status', compact('status', 'class', 'key', 'worksheet_number', 'route'))->render();
                })
                ->rawColumns(['status_monitoring'])
                ->make(true);
        }

        $units = Official::getSubUnitOnly()
            ->filterByRole(session()->get('current_role')?->name)
            ->orderBy('sub_unit_code', 'asc')
            ->get();

        return view('report.risk_monitoring.index', compact('title', 'units'));
    }

    public function export()
    {
        $worksheets = Worksheet::with([
            'monitorings' => fn($q) => $q->with(
                'alteration',
                'actualizations',
                'actualizations.mitigation.incident',
                'incident',
                'residuals',
            )->oldest('period_date'),
        ])
            ->whereStatusMonitoring('on progress monitoring')
            ->get();

        $identifications = WorksheetIdentification::identification_query()->whereIn('worksheet_id', $worksheets->pluck('id'))->get();
        $worksheets = $worksheets->map(function ($worksheet) use ($identifications) {
            $worksheet->identification = $identifications->firstWhere('worksheet_id', $worksheet->id);
            return $worksheet;
        });

        return Excel::download(new MonitoringActualizationExport($worksheets), 'test.xlsx');
    }
}
