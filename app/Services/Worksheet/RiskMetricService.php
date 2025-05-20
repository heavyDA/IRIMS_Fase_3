<?php

namespace App\Services\Worksheet;

use App\Models\Master\RiskMetric;
use App\Models\Master\Position;
use Exception;

final class RiskMetricService
{
    public static function get($unit): RiskMetric
    {
        $riskMetric = RiskMetric::where('organization_code', $unit->sub_unit_code)->first();
        if ($riskMetric) {
            return $riskMetric;
        }

        $level = get_unit_level($unit->sub_unit_code) - 1;
        if ($level == 0) {
            throw new Exception('Nilai Limit Risiko tidak ditemukan');
        }

        $unit = Position::ancestorHierarchyQuery($unit->sub_unit_code)
            ->where('level', $level)
            ->first();

        return self::get($unit);
    }
}
