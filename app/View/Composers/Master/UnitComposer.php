<?php

namespace App\View\Composers\Master;

use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Services\RoleService;
use Illuminate\View\View;

class UnitComposer
{
    public function compose(View $view)
    {
        $currentUnit = role()->getCurrentUnit();
        $currentLevel = role()->getUnitLevel();
        $currentLocations = Position::ancestorHierarchyQuery($currentUnit->sub_unit_code)
            ->whereBetween('level', [0, 2])
            ->orderBy('level')
            ->get();
        $activeLocation = $currentLocations->last();

        $isBranch = str_contains($activeLocation->sub_unit_name, 'KC ');
        if (!$isBranch && $currentLevel > 1) {
            $currentLocations->pop();
            $activeLocation = $currentLocations->last();
        }

        $units = Position::hierarchyQuery($activeLocation->sub_unit_code)
            ->whereBetween('level', [0, $activeLocation->level == 2 ? $activeLocation->level : 2])
            ->where(
                fn($q) => $q->whereNotNull('regional_category')->Where('regional_category', '!=', '')
            )
            ->orderBy('level', 'asc')
            ->orderBy('regional_category', 'asc')
            ->get()
            ->filter(fn($p) => $p->level == 1 || ($p->level == 2 && str_contains($p->sub_unit_name, 'KC ')));
        $unitsCount = $units->count();

        cache()->delete('current_unit_hierarchy.' . auth()->user()->employee_id . '.' . $currentUnit->sub_unit_code);
        $units = cache()->remember(
            'current_unit_hierarchy.' . auth()->user()->employee_id . '.' . $currentUnit->sub_unit_code,
            now()->addMinutes(5),
            fn() =>
            $units
                ->map(function ($p) use ($currentUnit, $unitsCount) {
                    $p->children = Position::hierarchyQuery($unitsCount > 1 ? $p->sub_unit_code : $currentUnit->sub_unit_code)
                        ->when(
                            $p->level == 1,
                            fn($q) => $q
                                ->when(
                                    !in_array($p->branch_code, ['PST', 'HO']),
                                    fn($q) => $q->where('level', $p->level + 1)->whereNotLike('sub_unit_name', 'KC %')
                                )
                        )
                        ->when($p->level == 2, fn($q) => $q->where('level', '>', $p->level))
                        ->orderBy('level', 'asc')
                        ->orderBy('sub_unit_code', 'asc')
                        ->get()
                        ->map(function ($c) use ($p) {
                            $c->parent_id = $p->sub_unit_code;
                            return $c;
                        })
                        ->toArray();
                    return $p;
                })
        );

        $view->with('units', $units);
    }
}
