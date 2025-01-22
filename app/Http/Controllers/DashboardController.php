<?php

namespace App\Http\Controllers;

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
        $units = Official::getSubUnitOnly()
            ->filterByRole(session()->get('current_role')?->name)
            ->get();


        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }

        $count_worksheet = DB::table('ra_worksheets')
            ->selectRaw("
                COALESCE(COUNT(IF(ra_worksheets.status = 'draft', 1, NULL))) as draft,
                COALESCE(COUNT(IF(ra_worksheets.status != 'draft' && ra_worksheets.status != 'approved', 1, NULL))) as progress,
                COALESCE(COUNT(IF(ra_worksheets.status = 'approved', 1, NULL))) as approved
            ")
            ->where('ra_worksheets.sub_unit_code', 'like', $unit)
            ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
            ->first();

        $count_mitigation = WorksheetMitigation::whereHas(
            'worksheet',
            fn($q) => $q->where('ra_worksheets.sub_unit_code', 'like', $unit)
                ->whereYear('ra_worksheets.created_at', request('year', date('Y')))
        )
            ->count();

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


        return view('dashboard.index', compact('units', 'count_worksheet', 'count_mitigation'));
    }
}
