<?php

namespace App\Services;

use App\Models\Master\Position;

class PositionService
{
    public function getUnitLocation()
    {
        $unit = role()->getCurrentUnit();
        $unitLevel = get_unit_level($unit->sub_unit_code);

        if ($unitLevel > 2) {
            $unit = Position::ancestorHierarchyQuery($unit->sub_unit_code)
                ->where('level', 2)
                ->first();
        } else if ($unit->sub_unit_code == 'ap') {
            $unit = Position::where('sub_unit_code', 'ap.50')
                ->first();
        }

        return $unit;
    }

    public function getUnitBelow(?string $unitParent = null, ?string $unitChild = null, ?bool $includeParent = false)
    {
        return Position::hierarchyQuery($unitParent, $includeParent)
            ->whereSubUnitCode($unitChild)
            ->first();
    }
}
