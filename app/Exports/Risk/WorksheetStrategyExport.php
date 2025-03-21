<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
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
    protected string $lastcolumn;

    public function __construct(private Collection $worksheets) {}

    public function collection()
    {
        return $this->worksheets->flatMap(function ($worksheet) {
            return collect($worksheet->strategies)->map(function ($strategy, $index) use ($worksheet) {
                $this->count += 1;
                return [
                    'No.' => $this->count,
                    'Pilihan Sasaran' => strip_html($worksheet->target_body),
                    'Pilihan Strategi' => strip_html($strategy->body),
                    'Hasil yang diharapkan' => strip_html($strategy->expected_feedback),
                    'Nilai Risiko' => strip_html($strategy->risk_value),
                    'Batas Nilai Risiko' => money_format((float) $strategy->risk_value_limit ?? '0'),
                    'Keputusan' => $strategy->decision,
                ];
            });
        });
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function styles(WorksheetExcel $sheet)
    {
        $this->lastColumn = $this->getLastColumn(count($this->headers[0]));

        // Style for headers
        $sheet->getStyle("A1:{$this->lastColumn}1")->applyFromArray([
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

        $columnWidths = [
            'A' => 8,
            'B' => 42,
            'C' => 54,
            'D' => 42,
            'E' => 36,
            'F' => 36,
            'G' => 18,
        ];

        foreach (range('A', $this->lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidths[$column] ?? 18);
        }

        // Merge cells with same values for specific columns
        excel_merge_same_values(
            $sheet,
            [
                'B',
                'F'
            ], // Columns to merge - adjusted for new column
            2, // Start from row 3 (after headers)
            $this->count + 1
        );

        $sheet->getStyle("A1:{$this->lastColumn}" . ($this->count + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle("A1:{$this->lastColumn}1")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("{$column}2:{$this->lastColumn}{$this->count}")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_TOP);
    }

    public function title(): string
    {
        return 'Strategy';
    }

    private function getColumnLetter(int $index): string
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
    }

    private function getLastColumn(int $columnCount): string
    {
        return $this->getColumnLetter($columnCount);
    }
}
