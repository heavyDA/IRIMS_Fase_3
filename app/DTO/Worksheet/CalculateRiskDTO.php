<?php

namespace App\DTO\Worksheet;

use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;

class CalculateRiskDTO
{
    public BUMNScale $scale;
    public Heatmap $probabilityScale;
    public float $exposure;
    public ?float $impactValue;

    public function __construct(BUMNScale $scale, Heatmap $probabilityScale, float $exposure, ?float $impactValue = 0)
    {
        $this->scale = $scale;
        $this->probabilityScale = $probabilityScale;
        $this->exposure = $exposure;
        $this->impactValue = $impactValue;
    }

    public function get(): array
    {
        return [
            'scale' => $this->scale,
            'impact_value' => $this->impactValue,
            'probability_scale' => $this->probabilityScale,
            'exposure' => $this->exposure,
        ];
    }
}
