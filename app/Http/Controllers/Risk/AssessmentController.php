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
        if (request()->ajax()) {
            $unit = Role::getDefaultSubUnit();

            if (Role::hasLookUpUnitHierarchy()) {
                $unit = request('unit') ? request('unit') . '%' : $unit;
            }

            $incidents = WorksheetIncident::incident_query()
                ->where('worksheet.sub_unit_code', 'like', $unit)
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

        $title = 'Risk Assessment';
        return view('risk.assessment.index', compact('title'));
    }
}
