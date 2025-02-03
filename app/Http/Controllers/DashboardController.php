<?php

namespace App\Http\Controllers;

use App\Models\RBAC\Role;
use App\Models\Risk\Monitoring;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetMitigation;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $current_role = session()?->get('current_role');
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }

        $count_worksheet = DB::table('ra_worksheets')
            ->selectRaw("
                COALESCE(COUNT(IF(ra_worksheets.status = 'draft', 1, NULL))) as draft,
                COALESCE(COUNT(IF(ra_worksheets.status != 'draft' and ra_worksheets.status != 'approved', 1, NULL))) as progress,
                COALESCE(COUNT(IF(ra_worksheets.status = 'approved', 1, NULL))) as approved
            ")
            ->where('ra_worksheets.sub_unit_code', 'like', $unit)
            ->when($current_role->name == 'risk admin', fn($q) => $q->where('ra_worksheets.created_by', $user->employee_id))
            ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
            ->first();

        $count_mitigation = WorksheetMitigation::whereHas(
            'worksheet',
            fn($q) => $q->where('ra_worksheets.sub_unit_code', 'like', $unit)
                ->when($current_role->name == 'risk admin', fn($q) => $q->where('ra_worksheets.created_by', $user->employee_id))
                ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
        )
            ->count();

        $count_mitigation_monitoring = DB::table('ra_monitorings as m')
            ->selectRaw('
                COUNT(IF(ma.actualization_plan_status <> "discontinue", 1, NULL)) as progress,
                COUNT(IF(ma.actualization_plan_status = "discontinue", 1, NULL)) as finished
            ')
            ->joinSub(
                DB::table('ra_monitorings')
                    ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                    ->groupBy('worksheet_id'),
                'latest',
                function ($join) {
                    $join->on('m.worksheet_id', '=', 'latest.worksheet_id');
                    $join->on('m.period_date', '=', 'latest.period_date');
                }
            )
            ->leftJoin('ra_worksheets as w', 'w.id', '=', 'm.worksheet_id')
            ->leftJoin('ra_monitoring_actualizations as ma', 'ma.monitoring_id', '=', 'm.id')
            ->whereLike('w.sub_unit_code', $unit)
            ->whereNotLike('w.personnel_area_code', 'Reg %')
            ->when($current_role->name == 'risk admin', fn($q) => $q->where('w.created_by', $user->employee_id))
            ->whereYear('w.created_at', request('year', date('Y')))
            ->groupBy('m.id')
            ->first();

        $level = Role::getTraverseLevel();
        $unit = Role::getDefaultSubUnit();

        $monitoring_progress = Monitoring::monitoring_progress_each_unit_query($unit, $level, request('year', date('Y')))
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

        return view('dashboard.index', compact('count_worksheet', 'count_mitigation', 'count_mitigation_monitoring', 'monitoring_progress'));
    }

    public function inherent_risk_scale()
    {
        $unit = Role::getDefaultSubUnit();
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        }

        $inherent_scales = DB::table('m_heatmaps')
            ->withExpression(
                'worksheets',
                WorksheetIdentification::query()
                    ->select('worksheet_id', 'inherent_risk_scale')
                    ->whereHas(
                        'worksheet',
                        fn($q) => $q
                            ->where('sub_unit_code', 'like', $unit)
                            ->when(session()->get('current_role')->name == 'risk admin', fn($q) => $q->where('created_by', auth()->user()->employee_id))
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

    public function residual_risk_scale()
    {
        $unit = Role::getDefaultSubUnit();
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
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
                        'i.risk_chronology_body'
                    )
                    ->leftJoin('ra_worksheet_identifications as i', 'w.id', '=', 'i.worksheet_id')
                    ->where('sub_unit_code', 'like', $unit)
                    ->when(session()->get('current_role')->name == 'risk admin', fn($q) => $q->where('created_by', auth()->user()->employee_id))
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
                        'mr.id',
                        'm.id as monitoring_id',
                        'mr.worksheet_incident_id',
                        'mr.risk_scale',
                        'mr.risk_level'
                    )
                    ->leftJoin('ra_monitoring_residuals as mr', 'mr.monitoring_id', '=', 'm.id')
                    ->whereRaw('
                            m.id IN (select id from latest_monitorings) AND
                            m.worksheet_id IN (select id from worksheets)
                        ')
            )
            ->selectRaw('m_heatmaps.risk_scale, m_heatmaps.risk_level, color, COUNT(m.worksheet_incident_id) as total')
            ->leftJoin('monitorings as m', 'm.risk_scale', '=', 'm_heatmaps.risk_scale')
            ->groupBy('risk_scale', 'risk_level')
            ->get();

        return response()->json([
            'data' => $residual_scales,
            'message' => 'success'
        ]);
    }

    public function monitoring_progress_child()
    {
        $unit = request('unit', Role::getDefaultSubUnit()) . '.%';
        $level = Role::getTraverseLevel($unit);

        $data = Monitoring::monitoring_progress_each_unit_query($unit, $level, request('year', date('Y')))
            ->whereNotLike('lu.personnel_area_code', 'Reg %')
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
