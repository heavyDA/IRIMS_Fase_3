<?php

namespace App\Services\Worksheet;

use App\DTO\Worksheet\CalculateRiskDTO;
use App\Exceptions\Services\WorksheetCalculateRiskException;
use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;
use Exception;

class WorksheetCalculateRiskService
{
    public function __construct(
        public ?string $category = 'kualitatif',
        public ?int $scale = 0,
        public ?int $probability = 0,
        public ?float $limit = 0,
    ) {}

    protected function determine_risk_scale(): BUMNScale | null
    {
        return BUMNScale::where('scale', $this->scale)
            ->where('impact_category', $this->category)
            ->first();
    }

    protected function determine_probability_scale(): BUMNScale | null
    {
        return BUMNScale::whereRaw("? BETWEEN min AND max", [$this->probability])
            ->where('impact_category', $this->category)
            ->first();
    }

    protected function determine_impact_probability_scale(BUMNScale $probabilityScale): Heatmap | null
    {
        return Heatmap::where('impact_scale', $this->scale)
            ->where('impact_probability', $probabilityScale->scale)
            ->first();
    }

    public function calculate(?float $impactValue = 0, ?BUMNScale $previousRiskScale = null): CalculateRiskDTO | null
    {
        try {
            $riskScale = $this->determine_risk_scale();
            if (!$riskScale) {
                throw new WorksheetCalculateRiskException("Can't calculate risk, risk scale is null");
            }

            $probabilityScale = $this->determine_probability_scale();
            if (!$probabilityScale) {
                throw new WorksheetCalculateRiskException("Can't calculate risk, probability scale is null");
            }

            $impactProbabilityScale = $this->determine_impact_probability_scale($probabilityScale);
            if (!$impactProbabilityScale) {
                throw new WorksheetCalculateRiskException("Can't calculate risk, impact probability scale is null");
            }

            if ($impactValue <= 0 && $this->category == 'kuantitatif') {
                throw new WorksheetCalculateRiskException("Can't calculate risk, impact value is less than or equal to zero");
            }

            if ($this->category == 'kualitatif') {
                if ($this->limit <= 0) {
                    throw new WorksheetCalculateRiskException("Can't calculate risk, limit value is less than or equal to zero");
                }

                $exposure = 0.01 * $this->limit * $riskScale->scale * ($this->probability / 100);
            } else {
                if ($previousRiskScale) {
                    $impactValue = ($riskScale->scale / $previousRiskScale->scale) * $impactValue;
                }
                $exposure = $impactValue * ($this->probability / 100);
            }

            return new CalculateRiskDTO($riskScale, $impactProbabilityScale, round($exposure, 2), $impactValue);
        } catch (Exception $e) {
            if ($e instanceof WorksheetCalculateRiskException) {
                throw new WorksheetCalculateRiskException($e->getMessage());
            }

            throw new Exception($e->getMessage());
        }

        return null;
    }
}
