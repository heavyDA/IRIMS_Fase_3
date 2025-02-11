<?php

namespace App\View\Composers\Master;

use App\Models\Master\Official;
use App\Services\EOffice\UnitService;
use Illuminate\View\View;

class UnitComposer
{
    public function compose(View $view)
    {
        $currentUnit = session()?->get('current_unit') ?? auth()->user();
        $units = collect([]);
        try {
            $units = cache()->remember(
                'auth.' . auth()->user()->employee_id . '.supervised_units.' . $currentUnit->sub_unit_code,
                now()->addMinutes(5),
                fn() =>
                    Official::getSubUnitOnly()
                    ->filterByRole(session()->get('current_role')?->name)
                    ->latest('sub_unit_code')
                    ->get()
            );
        } catch(\Exception $e) {
            logger()->error('[UnitComposer] ' . $e->getMessage());
        }

        $view->with('units', $units);
    }
}
