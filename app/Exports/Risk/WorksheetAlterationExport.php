<?php

namespace App\Exports\Risk;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Mews\Purifier\Facades\Purifier;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorksheetAlterationExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected array $headers = [
        'No.',
        'Sasaran Perusahaan',
        'Jenis Perubahan',
        'Peristiwa Risiko yang Terdampak atas Perubahan',
        'Penjelasan',
    ];
    protected $mergedCells = [];

    public function __construct(protected $alterations)
    {
        $this->alterations = $alterations->map(
            function ($alteration) {
                if (array_key_exists($alteration->worksheet_number, $this->mergedCells)) {
                    $this->mergedCells[$alteration->worksheet_number]++;
                } else {
                    $this->mergedCells[$alteration->worksheet_number] = 0;
                }

                return [
                    'worksheet_number' => $alteration->worksheet_number,
                    'target_body' => strip_html(Purifier::clean($alteration->target_body ?? '')),
                    'body' => strip_html(Purifier::clean($alteration->body ?? '')),
                    'impact' => strip_html(Purifier::clean($alteration->impact ?? '')),
                    'description' => strip_html(Purifier::clean($alteration->description ?? '')),
                ];
            }
        );
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->alterations;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 24,
            'B' => 40,
            'C' => 48,
            'D' => 48,
            'E' => 48,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $count = $this->alterations->count() + 1;

        $styles = [
            'A1:E1' => [
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1896A4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],

        ];

        if ($count > 1) {
            $styles["A2:E{$count}"] = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ];
        }

        $startRow = 2;
        foreach ($this->mergedCells as $lastRow) {
            $lastRow += $startRow;

            $sheet->mergeCells("A{$startRow}:A{$lastRow}");
            $sheet->mergeCells("B{$startRow}:B{$lastRow}");

            $startRow = $lastRow + 1;
        }

        return $styles;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function title(): string
    {
        return 'Ikhtisar Perubahan Profil Risiko';
    }
}
