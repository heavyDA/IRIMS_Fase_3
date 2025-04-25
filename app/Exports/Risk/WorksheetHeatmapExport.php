<?php

namespace App\Exports\Risk;

class WorksheetHeatmapExport extends BaseHeatmapExport
{
    public function __construct($worksheets)
    {
        $rows = [];
        $worksheets = $worksheets->map(function ($item) use (&$rows) {
            if (array_key_exists($item->id, $rows)) {
                $rows[$item->id] += 1;
            } else {
                $rows[$item->id] = 1;
            }

            return (object) [
                'worksheet_id' => $rows[$item->id],
                'risk_type' => 'inherent',
                'risk_scale' => $item->identification->inherent_impact_probability_scale,
                'risk_level' => $item->identification->inherent_impact_probability_level,
                'impact_scale' => $item->identification->inherent_impact_probability_impact_scale,
                'impact_probability' => $item->identification->inherent_impact_probability_probability_scale,
            ];
        });
        parent::__construct($worksheets);
    }

    public function title(): string
    {
        return 'Heatmap';
    }
}
