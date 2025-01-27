<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonitoringAlterationExport implements FromCollection, WithTitle,  WithHeadings, WithStyles
{
    protected array $headers = [
        'Data Item',
        'Jenis Perubahan',
        'Peristiwa Risiko yang Terdampak atas Perubahan',
        'Penjelasan',
    ];

    protected array $nested_columns = [];

    protected array $merged_cells = [];

    protected int $count = 0;

    public function __construct(private Collection $worksheets) {}
    public function collection()
    {
        $data = [];
        $this->worksheets->each(function ($worksheet) use (&$data) {
            $worksheet->monitorings->each(function ($monitoring) use ($worksheet, &$data) {
                $data[] = [
                    'Data Item' => $worksheet->worksheet_number,
                    'Jenis Perubahan' => $monitoring->alteration?->body,
                    'Peristiwa Risiko yang Terdampak atas Perubahan' => $monitoring->alteration?->impact,
                    'Penjelasan' => $monitoring->alteration?->description,
                ];
            });
        });
        $this->count = count($data);

        return collect($data);
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = $this->getLastColumn(count($this->headers));

        // Style for headers
        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1896A4']
            ],
        ]);

        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Merge cells with same values for specific columns
        excel_merge_same_values(
            $sheet,
            [
                'A',
            ], // Columns to merge - adjust as needed
            2, // Start from row 3 (after headers)
            $this->count + 1
        );

        $sheet->getStyle("A1:{$lastColumn}" . ($this->count + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle('A2:A' . ($this->count + 1))->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '00B050']
            ],
        ]);
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
        return 'Perubahan Strategi Risiko';
    }
}
