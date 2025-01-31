<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Models\Master\Official;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetMitigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
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
            ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
            ->first();

        $data_worksheet_priority = DB::table('m_heatmaps as h')
            ->selectRaw('h.risk_level, COALESCE(COUNT(w.inherent_impact_probability_scale_id), 0) as count')
            ->withExpression(
                'worksheets',
                DB::table('ra_worksheets as w')
                    ->select('wi.inherent_impact_probability_scale_id')
                    ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
                    ->where('w.sub_unit_code', 'like', $unit)
                    ->whereStatus(DocumentStatus::APPROVED->value)
                    ->whereYear('w.created_at', request('year', date('Y')))
            )
            ->leftJoin('worksheets as w', 'w.inherent_impact_probability_scale_id', '=', 'h.id')
            ->where('h.risk_scale', '>=', 12)
            ->groupBy('h.risk_level')
            ->orderBy('h.impact_scale', 'desc')
            ->get();

        $count_worksheet_priortiy = 0;
        foreach ($data_worksheet_priority as $item) {
            $count_worksheet_priortiy += $item->count;
        }

        $count_mitigation = WorksheetMitigation::whereHas(
            'worksheet',
            fn($q) => $q->where('ra_worksheets.sub_unit_code', 'like', $unit)
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
            ->where('w.sub_unit_code', 'like', $unit)
            ->whereYear('w.created_at', request('year', date('Y')))
            ->groupBy('m.id')
            ->first();

        if (request()->ajax()) {
            $inherent_scales = DB::table('m_heatmaps')
                ->withExpression(
                    'worksheets',
                    WorksheetIdentification::query()
                        ->select('worksheet_id', 'inherent_risk_scale')
                        ->whereHas(
                            'worksheet',
                            fn($q) => $q
                                ->where('sub_unit_code', 'like', $unit)
                                ->whereYear('created_at', request('year', date('Y')))
                        )
                )
                ->selectRaw('risk_scale, risk_level, COUNT(worksheets.worksheet_id) as total')
                ->leftJoin('worksheets', 'worksheets.inherent_risk_scale', '=', 'm_heatmaps.risk_scale')
                ->groupBy('risk_scale', 'risk_level')
                ->get();

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
                ->selectRaw('m_heatmaps.risk_scale, m_heatmaps.risk_level, COUNT(m.worksheet_incident_id) as total')
                ->leftJoin('monitorings as m', 'm.risk_scale', '=', 'm_heatmaps.risk_scale')
                ->groupBy('risk_scale', 'risk_level')
                ->get();

            return response()->json([
                'data' => [
                    'inherent_scales' => $inherent_scales,
                    'residual_scales' => $residual_scales
                ],
                'message' => 'success',
            ]);
        }

        $level = Role::getLevel();
        $units = Official::getSubUnitOnly()
            ->filterByRole(session()->get('current_role')?->name)
            ->whereRaw('LENGTH(sub_unit_code) - LENGTH(REPLACE(sub_unit_code, ".", "")) = ?', ($level + 1))
            ->latest('sub_unit_code')
            ->get();

        return view('dashboard.index', compact('units', 'count_worksheet', 'count_worksheet_priortiy', 'count_mitigation', 'count_mitigation_monitoring'));
    }
}
