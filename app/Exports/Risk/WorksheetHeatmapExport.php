<?php

namespace App\Exports\Risk;

class WorksheetHeatmapExport extends BaseHeatmapExport
{
    public function __construct($worksheets)
    {
        $data = [];
        foreach ($worksheets as $worksheet) {
            if (array_search($worksheet->worksheet_number, array_column($data, 'worksheet_id')) !== false) {
                continue;
            }

            $data[] = (object) [
                'worksheet_id' => $worksheet->worksheet_number,
                'risk_type' => 'inherent',
                'risk_scale' => $worksheet->identification->inherent_impact_probability_scale,
                'risk_level' => $worksheet->identification->inherent_impact_probability_level,
                'impact_scale' => $worksheet->identification->inherent_impact_probability_impact_scale,
                'impact_probability' => $worksheet->identification->inherent_impact_probability_probability_scale,
            ];
        }

        parent::__construct($data);
    }

    public function title(): string
    {
        return 'Heatmap';
    }
}
