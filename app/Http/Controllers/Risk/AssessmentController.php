<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Models\Risk\WorksheetIncident;
use App\Models\Risk\Worksheet;

use App\Http\Controllers\Controller;
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
                ->where('worksheet.sub_unit_code', 'like', $unit);


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

        $title = 'Risk Assessment';

        return view('risk.assessment.index', compact('title'));
    }
}
