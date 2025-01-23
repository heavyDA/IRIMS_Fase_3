<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Exports\Risk\WorksheetExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Official;
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
        if (request()->ajax()) {
            if (Role::hasLookUpUnitHierarchy()) {
                $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
            } else {
                $unit = Role::getDefaultSubUnit();
            }

            $incidents = WorksheetIncident::incident_query()
                ->where('worksheet.sub_unit_code', 'like', $unit)
                ->when(request()->year, fn($q) => $q->whereYear('worksheet.created_at', request()->year))
                ->when(
                    request()->document_status,
                    function ($q) {
                        if (in_array(request()->document_status, ['draft', 'approved'])) {
                            return $q->whereStatus(request()->document_status);
                        }

                        return $q->whereNotIn('status', ['draft', 'approved']);
                    }
                );

            return DataTables::query($incidents)
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

        $units = Official::getSubUnitOnly()
            ->filterByRole(session()->get('current_role')?->name)
            ->latest('sub_unit_code')
            ->get();
        $title = 'Risk Profile';

        return view('report.risk_profile.index', compact('title', 'units'));
    }

    public function export()
    {
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }

        $worksheets = Worksheet::with([
            'strategies',
            'incidents.kri_unit',
            'incidents.mitigations',
            'incidents.mitigations.risk_treatment_option',
            'incidents.mitigations.risk_treatment_type',
            'incidents.mitigations.rkap_program_type',
        ])
            ->where('sub_unit_code', 'like', $unit)
            ->when(request()->year, fn($q) => $q->whereYear('created_at', request()->year))
            ->documentStatus(request()->document_status)
            ->when(request('length') > 0, fn($q) => $q->limit(request('length')))
            ->get();

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
