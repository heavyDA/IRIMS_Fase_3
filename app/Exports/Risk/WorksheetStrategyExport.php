<?php

namespace App\Exports\Risk;

use App\Models\Risk\Assessment\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as WorksheetExcel;

class WorksheetStrategyExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected array $headers = [
        [
            'No.',
            'Pilihan Sasaran',
            'Pilihan Strategi',
            'Hasil yang diharapkan',
            'Nilai Risiko',
            'Batas Nilai Risiko',
            'Keputusan'
        ]
    ];

    protected int $count = 0;
    public function __construct(public Worksheet $worksheet) {}

    public function collection()
    {
        return collect($this->worksheet->target->strategies)->map(function ($strategy, $index) {
            $this->count += 1;
            return [
                'No.' => $index + 1,
                'Pilihan Sasaran' => strip_html($this->worksheet->target->body),
                'Pilihan Strategi' => strip_html($strategy->body),
                'Hasil yang diharapkan' => strip_html($strategy->expected_feedback),
                'Nilai Risiko' => strip_html($strategy->risk_value),
                'Batas Nilai Risiko' => money_format((float) $strategy->risk_value_limit ?? '0'),
                'Keputusan' => $strategy->decision,
            ];
        });
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function styles(WorksheetExcel $sheet)
    {
        $lastColumn = $this->getLastColumn(count($this->headers[0]));

        // Style for headers
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1896A4']
            ],
        ]);

        $sheet->getStyle("A1:{$lastColumn}" . ($this->count + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Auto-size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Merge cells with same values for specific columns
        excel_merge_same_values(
            $sheet,
            [
                'B',
                'F'
            ], // Columns to merge - adjust as needed
            3, // Start from row 3 (after headers)
            $this->count + 1
        );
    }

    private function getColumnLetter(int $index): string
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
    }

    private function getLastColumn(int $columnCount): string
    {
        return $this->getColumnLetter($columnCount);
    }

    public function title(): string
    {
        return 'Pilihan Sasaran&Strategi Bisnis';
    }
}
