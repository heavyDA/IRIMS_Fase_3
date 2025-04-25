<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorksheetExport implements WithMultipleSheets
{

    public function __construct(private Collection $worksheets) {}

    public function sheets(): array
    {
        return [
            new WorksheetStrategyExport($this->worksheets),
            new WorksheetContextExport($this->worksheets),
            new WorksheetInherentExport($this->worksheets),
            new WorksheetInherentExport($this->worksheets, 'kualitatif'),
            new WorksheetResidualExport($this->worksheets),
            new WorksheetResidualExport($this->worksheets, 'kualitatif'),
            new WorksheetTreatmentExport($this->worksheets),
            new WorksheetHeatmapExport($this->worksheets),
        ];
    }
}
