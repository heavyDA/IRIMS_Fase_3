<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\Master\Position;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIncident;
use App\Models\Risk\WorksheetTopRisk;
use App\Services\PositionService;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Yajra\DataTables\Facades\DataTables;

class TopRiskController extends Controller
{
    public function __construct(
        private RoleService $roleService,
        private PositionService $positionService
    ) {}

    public function index()
    {
        if (request()->ajax()) {
            $unit = $this->roleService->getCurrentUnit();
            $currentUnit = $this->roleService->getCurrentUnit();
            $currentLevel = $this->roleService->getUnitLevel();

            if (request('unit')) {
                $unit = $this->positionService->getUnitBelow(
                    $unit?->sub_unit_code,
                    request('unit'),
                    $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                ) ?: $unit;
            }

            if ($currentLevel < 2) {
                $worksheets = Worksheet::topRiskUpperQuery(
                    $currentUnit->sub_unit_code,
                    $currentUnit->sub_unit_code
                )
                    ->withExpression(
                        'position_hierarchy',
                        Position::hierarchyQuery(
                            $unit?->sub_unit_code ?? '-',
                            true
                        )
                    )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                    ->whereYear('w.created_at', request('year', date('Y')))
                    ->where('w.status', DocumentStatus::APPROVED->value);
            } else {
                $worksheets = Worksheet::topRiskLowerQuery(
                    $currentLevel > 2 ? get_unit_manager($currentUnit->sub_unit_code) : $currentUnit->sub_unit_code
                )
                    ->withExpression(
                        'position_hierarchy',
                        Position::hierarchyQuery(
                            $unit?->sub_unit_code ?? '-',
                            $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                        )
                    )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                    ->whereYear('w.created_at', request('year', date('Y')))
                    ->where('w.status', DocumentStatus::APPROVED->value);
            }

            return DataTables::query($worksheets)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                                ->orWhereLike('w.target_body', '%' . $value . '%')
                                ->orWhereLike('wi.risk_chronology_body', '%' . $value . '%')
                                ->orWhereLike('wi.risk_impact_body', '%' . $value . '%')
                                ->orWhereLike('winc.risk_cause_body', '%' . $value . '%')
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
                ->editColumn('status', function ($worksheet) {
                    $status = DocumentStatus::tryFrom($worksheet->status);
                    $class = $status?->color() ?? 'info';
                    $worksheet_number = $worksheet->worksheet_number;
                    $route = route('risk.worksheet.show', Crypt::encryptString($worksheet->id));

                    return view('risk.top_risk._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
                })
                ->editColumn('top_risk_action', function ($worksheet) use ($currentLevel) {
                    if (
                        $currentLevel >= 2 && $worksheet->source_sub_unit_code
                    ) {
                        return view('risk.top_risk._table_checked');
                    } else if ($currentLevel < 2 && $worksheet->top_risk_submit_id) {
                        return view('risk.top_risk._table_checked');
                    }

                    if (
                        $this->roleService->isRiskOtorisatorTopRiskApproval() ||
                        ($this->roleService->isRiskAnalis() && $currentLevel <= 2)
                    ) {
                        return view('risk.top_risk._table_checkbox', ['id' => $worksheet->id]);
                    }

                    return '';
                })
                ->rawColumns(['status', 'top_risk_action'])
                ->make(true);
        }

        $title = 'Top Risk';

        return view('risk.top_risk.index', compact('title'));
    }

    public function get_for_dashboard()
    {
        $unit = $this->roleService->getCurrentUnit();
        $currentUnit = $this->roleService->getCurrentUnit();
        $currentLevel = $this->roleService->getUnitLevel();

        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }

        if ($currentLevel < 2) {
            $worksheets = Worksheet::topRiskUpperDashboardQuery(
                $currentUnit->sub_unit_code,
                $currentUnit->sub_unit_code
            )
                ->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        true
                    )
                )
                ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                ->where('w.status', DocumentStatus::APPROVED->value)
                ->whereYear('w.created_at', request('year', date('Y')))
                ->whereNotNull('wtr_submit.id')
                ->orderBy('w.id', 'desc')
                ->groupBy('winc.id', 'wim.id');
        } else {
            $worksheets = Worksheet::topRiskLowerDashboardQuery(
                $currentLevel > 2 ? get_unit_manager($currentUnit->sub_unit_code) : $currentUnit->sub_unit_code
            )
                ->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        true
                    )
                )
                ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
                ->where('w.status', DocumentStatus::APPROVED->value)
                ->whereYear('w.created_at', request('year', date('Y')))
                ->whereNotNull('wtr.id')
                ->orderBy('w.id', 'desc')
                ->groupBy('winc.id', 'wim.id');
        }

        return DataTables::query($worksheets)
            ->filter(function ($q) {
                $value = request('search.value');

                if ($value) {
                    $q->where(
                        fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                            ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                            ->orWhereLike('w.target_body', '%' . $value . '%')
                            ->orWhereLike('wi.risk_chronology_body', '%' . $value . '%')
                            ->orWhereLike('wi.risk_impact_body', '%' . $value . '%')
                            ->orWhereLike('winc.risk_cause_body', '%' . $value . '%')
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
            ->editColumn('status', function ($worksheet) {
                $status = DocumentStatus::tryFrom($worksheet->status);
                $class = $status?->color() ?? 'info';
                $worksheet_number = $worksheet->worksheet_number;
                $route = route('risk.worksheet.show', Crypt::encryptString($worksheet->id));

                return view('risk.top_risk._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
            })
            ->editColumn('top_risk_action', function ($worksheet) use ($currentLevel) {
                if (
                    $currentLevel >= 2 && $worksheet->source_sub_unit_code
                ) {
                    return view('risk.top_risk._table_checked');
                } else if ($currentLevel < 2 && $worksheet->top_risk_submit_id) {
                    return view('risk.top_risk._table_checked');
                }

                return '';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function store(Request $request)
    {

        try {
            throw_if(
                !Role::risk_otorisator_top_risk_approval() && !auth()->user()->hasAnyRole('superadmin', 'root', 'risk analis', 'risk otorisator'),
                new Exception('Failed to submit top risk, User ID: ' . auth()->user()->employee_id . ' doesn\'t have access')
            );


            $worksheets = Worksheet::whereIn('id', array_unique($request->worksheets))->get();

            DB::beginTransaction();
            WorksheetTopRisk::upsert(
                $worksheets->map(function ($worksheet) {
                    $user = auth()->user();

                    return [
                        'worksheet_id' => $worksheet->id,
                        'sub_unit_code' => $user->sub_unit_code == 'ap' ? 'root' : $user->unit_code,
                        'source_sub_unit_code' => $user->sub_unit_code,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray(),
                ['worksheet_id', 'sub_unit_code', 'source_sub_unit_code']
            );
            DB::commit();
            return response()->json(
                ['message' => 'Profil Risiko berhasil disimpan sebagai top risk.'],
                ResponseStatus::HTTP_OK
            )->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Risk Profile] Gagal menyimpan top risk. ' . $e->getMessage());
            return response()->json(
                ['message' => 'Profil Risiko gagal disimpan sebagai top risk.'],
                ResponseStatus::HTTP_BAD_REQUEST
            )->header('Cache-Control', 'no-store');
        }
    }
}
