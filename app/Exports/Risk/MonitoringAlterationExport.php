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
use Soundasleep\Html2Text;

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

    protected string $lastColumn;

    public function __construct(private Collection $worksheets) {}
    public function collection()
    {
        $data = [];
        $this->worksheets->each(function ($worksheet) use (&$data) {
            $worksheet->monitorings->each(function ($monitoring) use ($worksheet, &$data) {
                $data[] = [
                    'Data Item' => $worksheet->worksheet_number,
                    'Jenis Perubahan' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->alteration?->body ?? ''), ['ignore_errors' => true])),
                    'Peristiwa Risiko yang Terdampak atas Perubahan' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->alteration?->impact ?? ''), ['ignore_errors' => true])),
                    'Penjelasan' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->alteration?->description ?? ''), ['ignore_errors' => true])),
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
        $this->lastColumn = $this->getLastColumn(count($this->headers));

        // Style for headers
        $sheet->getStyle("A1:{$this->lastColumn}1")->applyFromArray([
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

        $columnWidths = [
            'A' => 20,
            'B' => 42,
            'C' => 54,
            'D' => 54,
        ];

        foreach (range('A', $this->lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidths[$column] ?? 18);
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

        $sheet->getStyle("A1:{$this->lastColumn}" . ($this->count + 1))->applyFromArray([
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

        $sheet->getStyle("A1:{$this->lastColumn}1")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A2:{$this->lastColumn}" . $this->count + 1)
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_TOP);
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
