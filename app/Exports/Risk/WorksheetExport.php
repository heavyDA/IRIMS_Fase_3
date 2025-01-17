<?php

namespace App\Exports\Risk;

use App\Models\Risk\Assessment\Worksheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class WorksheetExport implements WithMultipleSheets
{
    public function __construct(public Worksheet $worksheet) {}

    public function sheets(): array
    {
        $sheets = [
            new WorksheetStrategyExport($this->worksheet),
            new WorksheetContextExport($this->worksheet),
            new WorksheetInherentExport($this->worksheet),
            new WorksheetResidualExport($this->worksheet),
            new WorksheetTreatmentExport($this->worksheet),
        ];

        return $sheets;
    }
}
