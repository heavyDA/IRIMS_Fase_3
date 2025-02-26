<?php

namespace App\Services;

use App\Models\Master\Position;

class PositionService
{
    public function getUnitBelow(?string $unitParent = null, ?string $unitChild = null, ?bool $includeParent = false)
    {
        return Position::hierarchyQuery($unitParent, $includeParent)
            ->whereSubUnitCode($unitChild)
            ->first();
    }
}
