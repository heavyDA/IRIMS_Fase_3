<?php

namespace App\Http\Controllers;

use App\Models\Master\Official;
use App\Models\RBAC\Role;
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

        return view('dashboard.index', compact('units', 'count_worksheet', 'count_mitigation'));
    }
}
