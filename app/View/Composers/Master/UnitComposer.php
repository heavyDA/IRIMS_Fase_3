<?php

namespace App\View\Composers\Master;

use App\Models\Master\Official;
use App\Services\EOffice\UnitService;
use Illuminate\View\View;

class UnitComposer
{
    public function compose(View $view)
    {
        $unitService = new UnitService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
        $currentUnit = session()?->get('current_unit') ?? auth()->user();
        $units = collect([]);

        try {
            $units = cache()->remember(
                'auth.' . auth()->user()->employee_id . '.supervised_units.' . $currentUnit->sub_unit_code,
                now()->addMinutes(5),
                fn() =>
                    session()?->get('current_role')?->name == 'risk analis' ?
                    $unitService->get_all() :
                    $unitService->get_supervised($currentUnit->sub_unit_code)
            );
        } catch(\Exception $e) {
            logger()->error('[UnitComposer] ' . $e->getMessage());
        }

        $view->with('units', $units);
    }
}
