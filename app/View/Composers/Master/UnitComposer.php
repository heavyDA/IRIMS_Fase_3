<?php

namespace App\View\Composers\Master;

use App\Models\Master\Official;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class UnitComposer
{
    public function compose(View $view)
    {
        $units = Cache::remember(
            'auth.' . auth()->user()->employee_id . '.related_units',
            now()->addHours(1),
            fn() => Official::getSubUnitOnly()
                ->filterByRole(session()->get('current_role')?->name)
                ->latest('sub_unit_code')
                ->get()
        );

        $view->with('units', $units);
    }
}
