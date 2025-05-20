<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Models\Risk\WorksheetIncident;

use App\Http\Controllers\Controller;
use App\Models\Master\Position;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Services\PositionService;
use App\Services\RoleService;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AssessmentController extends Controller
{
    public function __construct(
        private PositionService $positionService
    ) {}

    public function index()
    {
        if (request()->ajax()) {
            $unit = role()->getCurrentUnit();
            if (request('unit')) {
                $unit = $this->positionService->getUnitBelow(
                    $unit?->sub_unit_code,
                    request('unit'),
                    role()->isRiskOwner() || role()->isRiskAdmin()
                ) ?: $unit;
            }

            $date = format_year_month((int) request('year', date('Y')), (int) request('month'));
            $worksheets = Worksheet::assessmentQuery()
                ->when(
                    !role()->isRiskAdmin(),
                    fn($q) => $q->withExpression(
                        'position_hierarchy',
                        Position::hierarchyQuery(
                            $unit?->sub_unit_code ?? '-',
                            role()->isRiskOwner() || role()->isRiskAdmin()
                        )
                    )
                        ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                )
                ->when(role()->isRiskAdmin(), fn($q) => $q->where('w.sub_unit_code', $unit?->sub_unit_code ?? ''))
                ->when(
                    request('document_status'),
                    function ($q) {
                        if (in_array(request('document_status'), ['draft', 'approved'])) {
                            return $q->whereStatus(request('document_status'));
                        }

                        return $q->whereNotIn('status', ['draft', 'approved']);
                    }
                )
                ->when(is_array($date), fn($q) => $q->whereBetween('w.created_at', $date))
                ->when(is_int($date), fn($q) => $q->whereYear('w.created_at', $date))
                ->when(request('risk_qualification'), fn($q) => $q->where('rq.id', request('risk_qualification')));

            return DataTables::query($worksheets)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->whereLike('w.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('rq.name', '%' . $value . '%')
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

        $title = 'Risk Assessment';
        return view('risk.assessment.index', compact('title'));
    }
}
