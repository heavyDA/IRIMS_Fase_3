<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MonitoringExport implements WithMultipleSheets
{
    public function __construct(private Collection $worksheets) {}

    public function sheets(): array
    {
        return [
            new MonitoringActualizationExport($this->worksheets),
            new MonitoringAlterationExport($this->worksheets),
            new MonitoringIncidentExport($this->worksheets),
            new MonitorinResidualExport($this->worksheets),
        ];
    }
}
