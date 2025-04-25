<?php

namespace App\Exports\Risk;

class MonitoringHeatmapExport extends BaseHeatmapExport
{
    public function __construct($worksheets)
    {
        $data = [];

        foreach ($worksheets as $worksheet) {
            if (array_search($worksheet->worksheet_number, array_column($data, 'worksheet_id')) !== false) {
                continue;
            }

            $latestQuarter = 1;
            $currentQuarter = $worksheet->monitorings->first()?->residual;

            foreach ($worksheet->monitorings as $monitoring) {
                if ($monitoring->residual->quarter > $latestQuarter) {
                    $latestQuarter = $monitoring->residual->quarter;
                    $currentQuarter = $monitoring->residual;
                }
            }

            $targetScale = "residual_{$latestQuarter}_impact_probability_scale";
            $targetLevel = "residual_{$latestQuarter}_impact_probability_level";
            $targetImpactScale = "residual_{$latestQuarter}_impact_probability_impact_scale";
            $targetImpactProbabilityScale = "residual_{$latestQuarter}_impact_probability_probability_scale";

            if ($currentQuarter) {
                $data[] = (object) [
                    'worksheet_id' => $worksheet->worksheet_number,
                    'risk_type' => 'inherent',
                    'risk_scale' => $worksheet->identification->$targetScale,
                    'risk_level' => $worksheet->identification->$targetLevel,
                    'impact_scale' => $worksheet->identification->$targetImpactScale,
                    'impact_probability' => $worksheet->identification->$targetImpactProbabilityScale,
                ];

                $data[] = (object) [
                    'worksheet_id' => $worksheet->worksheet_number,
                    'risk_type' => 'residual',
                    'risk_scale' => $currentQuarter->impact_probability_scale->risk_scale,
                    'risk_level' => $currentQuarter->impact_probability_scale->risk_level,
                    'impact_scale' => $currentQuarter->impact_probability_scale->impact_scale,
                    'impact_probability' => $currentQuarter->impact_probability_scale->impact_probability,
                ];
            }
        }

        parent::__construct($data);
    }

    public function title(): string
    {
        return 'Heatmap';
    }
}
