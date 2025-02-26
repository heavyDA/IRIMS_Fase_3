<?php

namespace App\Services\Worksheet;

use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;

class WorksheetService
{
    public function __construct(
        public string $category,
        public BUMNScale $scale,
        public ?float $probability = 0,
        public ?float $value = 0,
        public ?BUMNScale $previousScale = null,
    ) {}

    protected function calculate_risk_exposure(): float
    {
        $exposure = 0;
        if ($this->category == 'kuantitatif') {
            $exposure = $this->value * ($this->probability / 100);
        } else if ($this->category == 'kualitatif') {
            $exposure =
                1 / 100 * $this->value * $this->scale->scale * ($this->probability / 100);
        }

        return $exposure;
    }

    protected function determine_probability_scale()
    {
        $probability = BUMNScale::whereScale($this->scale->scale)
            ->whereRaw('min <= ? and max >= ?', [$this->probability, $this->probability])
            ->first();

        return Heatmap::whereImpactScale($this->scale->scale)
            ->whereImpactProbability($probability->scale)
            ->first();
    }

    protected function calculate_impact_value()
    {
        if (!$this->previousScale) {
            return $this->value;
        }

        $this->value = ($this->scale->scale / $this->previousScale->scale) * $this->value;

        return $this;
    }

    public function calculate()
    {
        $exposure = $this->calculate_risk_exposure();
        $probabilityScale = $this->determine_probability_scale();

        return [
            'impact_value' => $this->value,
            'impact_probability_scale_id' => $probabilityScale->id,
            'risk_exposure'  => $exposure,
            'risk_level' => $probabilityScale->risk_level,
            'risk_scale' => $probabilityScale->risk_scale
        ];
    }
}
