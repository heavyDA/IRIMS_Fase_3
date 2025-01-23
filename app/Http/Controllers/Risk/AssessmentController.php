<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Models\Risk\WorksheetIncident;
use App\Models\Risk\Worksheet;

use App\Http\Controllers\Controller;
use App\Models\Master\Official;
use App\Models\RBAC\Role;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AssessmentController extends Controller
{
    public function index()
    {
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }

        if (request()->ajax()) {

            $incidents = WorksheetIncident::incident_query()
                ->where('worksheet.sub_unit_code', 'like', $unit)
                ->whereRaw('YEAR(worksheet.created_at)= ?', request('year', date('Y')))
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

                    return view('risk.assessment._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $years = Worksheet::selectRaw('year(created_at) as year')->distinct()->get()->pluck('year');
        $units = Official::getSubUnitOnly()
            ->filterByRole(session()->get('current_role')?->name)
            ->latest('sub_unit_code')
            ->get();
        $title = 'Risk Assessment';

        return view('risk.assessment.index', compact('title', 'units', 'years'));
    }
}
