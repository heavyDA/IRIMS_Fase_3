<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Models\Master\Position;
use App\Models\RBAC\Role;
use App\Models\Risk\Monitoring;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetMitigation;
use App\Services\PositionService;
use App\Services\RoleService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function __construct(
        private RoleService $roleService,
        private PositionService $positionService
    ) {}

    public function index()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }
        $levels = $this->roleService->getTraverseUnitLevel($unit?->sub_unit_code, 1);

        $count_worksheet = Worksheet::getCountByStatus($unit?->sub_unit_code)
            ->withExpression(
                'position_hierarchy',
                Position::hierarchyQuery(
                    $unit?->sub_unit_code,
                    $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                )
            )
            ->join('position_hierarchy as ph', 'ra_worksheets.sub_unit_code', 'ph.sub_unit_code')
            ->when(
                $this->roleService->isRiskAdmin(),
                fn($q) => $q->whereBetween('ph.level', $levels)
            )
            ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
            ->first();

        $count_mitigation = WorksheetMitigation::whereHas(
            'worksheet',
            fn($q) => $q
                ->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code,
                        $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                    )
                )
                ->join('position_hierarchy as ph', 'ra_worksheets.sub_unit_code', 'ph.sub_unit_code')
                ->when(
                    $this->roleService->isRiskAdmin(),
                    fn($q) => $q->whereBetween('ph.level', $levels)
                )
                ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
        )
            ->count();

        $count_mitigation_monitoring = Monitoring::getMonitoringByStatus()
            ->withExpression(
                'position_hierarchy',
                Position::hierarchyQuery(
                    $unit?->sub_unit_code,
                    $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                )
            )
            ->join('position_hierarchy as ph', 'w.sub_unit_code', 'ph.sub_unit_code')
            ->when(
                $this->roleService->isRiskAdmin(),
                fn($q) => $q->whereBetween('ph.level', $levels)
            )
            ->whereYear('w.created_at', request('year', date('Y')))
            ->first();

        return view('dashboard.index', compact('count_worksheet', 'count_mitigation', 'count_mitigation_monitoring'));
    }

    public function get_monitoring_progress()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }

        if ($this->roleService->isRiskOwner() && !request('unit')) {
            $monitorings = Worksheet::progressMonitoringRiskOwnerQuery($unit?->sub_unit_code, request('year', date('Y')));
        } else {
            $monitorings = Worksheet::progressMonitoringQuery($unit?->sub_unit_code, request('year', date('Y')));
        }

        return DataTables::of($monitorings)
            ->make(true);
    }

    public function inherent_risk_scale()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }
        $levels = $this->roleService->getTraverseUnitLevel($unit->sub_unit_code, 1);

        $inherent_scales = DB::table('m_heatmaps')
            ->withExpression(
                'worksheets',
                WorksheetIdentification::query()
                    ->select('worksheet_id', 'inherent_risk_scale')
                    ->whereHas(
                        'worksheet',
                        fn($q) => $q
                            ->withExpression(
                                'position_hierarchy',
                                Position::hierarchyQuery(
                                    $unit?->sub_unit_code,
                                    $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                                )
                            )
                            ->join('position_hierarchy as ph', 'ra_worksheets.sub_unit_code', 'ph.sub_unit_code')
                            ->where('status', '!=', DocumentStatus::DRAFT->value)
                            ->when(
                                $this->roleService->isRiskAdmin(),
                                fn($q) => $q->whereBetween('ph.level', $levels)
                            )
                            ->whereYear('created_at', request('year', date('Y')))
                    )
            )
            ->selectRaw('risk_scale, risk_level, color, COUNT(worksheets.worksheet_id) as total')
            ->leftJoin('worksheets', 'worksheets.inherent_risk_scale', '=', 'm_heatmaps.risk_scale')
            ->groupBy('risk_scale', 'risk_level')
            ->get();

        return response()->json([
            'data' => $inherent_scales,
            'message' => 'success'
        ]);
    }

    public function target_residual_risk_scale()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }
        $levels = $this->roleService->getTraverseUnitLevel($unit->sub_unit_code, 1);

        $quarter = (int) request('quarter', 1);
        if ($quarter < 1 || $quarter > 4) {
            $quarter = 1;
        }

        $residual_scales = DB::table('m_heatmaps')
            ->withExpression(
                'worksheets',
                DB::table('ra_worksheets as w')
                    ->select(
                        'w.id',
                        'w.sub_unit_code',
                        'w.sub_unit_name',
                        'w.personnel_area_code',
                        'i.risk_chronology_body',
                        "residual_{$quarter}_impact_probability_scale_id"
                    )
                    ->leftJoin('ra_worksheet_identifications as i', 'w.id', '=', 'i.worksheet_id')
                    ->withExpression(
                        'position_hierarchy',
                        Position::hierarchyQuery(
                            $unit?->sub_unit_code,
                            $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                        )
                    )
                    ->join('position_hierarchy as ph', 'w.sub_unit_code', 'ph.sub_unit_code')
                    ->where('w.status', '!=', DocumentStatus::DRAFT->value)
                    ->when(
                        $this->roleService->isRiskAdmin(),
                        fn($q) => $q->whereBetween('ph.level', $levels)
                    )
                    ->whereYear('w.created_at', request('year', date('Y')))
            )
            ->selectRaw('m_heatmaps.risk_scale, m_heatmaps.risk_level, color, COUNT(w.id) as total')
            ->leftJoin('worksheets as w', "w.residual_{$quarter}_impact_probability_scale_id", '=', 'm_heatmaps.id')
            ->groupBy('risk_scale', 'risk_level')
            ->get();

        return response()->json([
            'data' => $residual_scales,
            'message' => 'success'
        ]);
    }

    public function residual_risk_scale()
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }
        $levels = $this->roleService->getTraverseUnitLevel($unit->sub_unit_code, 1);

        $residual_scales = DB::table('m_heatmaps')
            ->withExpression(
                'worksheets',
                DB::table('ra_worksheets as w')
                    ->select(
                        'w.id',
                        'w.sub_unit_code',
                        'w.sub_unit_name',
                        'w.personnel_area_code',
                        'i.risk_chronology_body'
                    )
                    ->leftJoin('ra_worksheet_identifications as i', 'w.id', '=', 'i.worksheet_id')
                    ->withExpression(
                        'position_hierarchy',
                        Position::hierarchyQuery(
                            $unit?->sub_unit_code,
                            $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                        )
                    )
                    ->join('position_hierarchy as ph', 'w.sub_unit_code', 'ph.sub_unit_code')
                    ->where('w.status', '!=', DocumentStatus::DRAFT->value)
                    ->when(
                        $this->roleService->isRiskAdmin(),
                        fn($q) => $q->whereBetween('ph.level', $levels)
                    )
                    ->whereYear('w.created_at', request('year', date('Y')))
            )
            ->withExpression(
                'latest_monitorings',
                DB::table('ra_monitorings as m')
                    ->selectRaw('max(m.id) as id, max(period_date)')
                    ->leftJoin('worksheets as w', 'w.id', '=', 'm.worksheet_id')
                    ->groupBy('w.id')
            )
            ->withExpression(
                'monitorings',
                DB::table('ra_monitorings as m')
                    ->select(
                        'm.id',
                        'mr.impact_probability_scale_id',
                        'h.risk_scale',
                        'h.risk_level'
                    )
                    ->leftJoin('ra_monitoring_residuals as mr', 'mr.monitoring_id', '=', 'm.id')
                    ->leftJoin('m_heatmaps as h', 'h.id', '=', 'mr.impact_probability_scale_id')
                    ->whereRaw('
                            m.id IN (select id from latest_monitorings) AND
                            m.worksheet_id IN (select id from worksheets)
                        ')
            )
            ->selectRaw('m_heatmaps.risk_scale, m_heatmaps.risk_level, color, COALESCE(COUNT(m.id), 0) as total')
            ->leftJoin('monitorings as m', 'm.impact_probability_scale_id', '=', 'm_heatmaps.id')
            ->groupBy('risk_scale', 'risk_level')
            ->get();

        return response()->json([
            'data' => $residual_scales,
            'message' => 'success'
        ]);
    }

    public function monitoring_progress_child()
    {
        $unit = request('unit', Role::getDefaultSubUnit());
        $unit = str_contains($unit, '.%') ? $unit : $unit . '.%';
        $level = Role::getTraverseLevel($unit);

        $data = Monitoring::monitoring_progress_each_unit_query($unit, $level, request('year', date('Y')))
            ->whereNotLike('lu.personnel_area_code', 'REG%')
            ->get()
            ->map(function ($monitoring) {
                $months = collect($monitoring)->flatten()->toArray();

                return (object) [
                    'sub_unit_code' => $monitoring->sub_unit_code,
                    'personnel_area_code' => $monitoring->personnel_area_code,
                    'name' => "[{$monitoring->personnel_area_code}] {$monitoring->sub_unit_name}",
                    'month' => array_splice($months, 4)
                ];
            })
            ->sortBy('sub_unit_code');

        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
}
