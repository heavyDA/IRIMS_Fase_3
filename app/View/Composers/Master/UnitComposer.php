<?php

namespace App\View\Composers\Master;

use App\Models\Master\Position;
use App\Services\RoleService;
use Illuminate\View\View;

class UnitComposer
{
    public function __construct(private RoleService $roleService) {}
    public function compose(View $view)
    {
        $currentUnit = $this->roleService->getCurrentUnit();
        $units = collect([]);

        try {
            $units = cache()->remember(
                'current_unit_hierarchy.' . auth()->user()->employee_id . '.' . $currentUnit->sub_unit_code,
                now()->addMinutes(5),
                fn() =>
                Position::hierarchyQuery($currentUnit->sub_unit_code, $this->roleService->isRiskOwner())
                    ->whereBetween('level', $this->roleService->getTraverseUnitLevel())
                    ->latest('unit_code')
                    ->get()
            );
        } catch (\Exception $e) {
            logger()->error('[UnitComposer] ' . $e->getMessage());
        }

        $view->with('units', $units);
    }
}
