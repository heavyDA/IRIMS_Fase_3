<?php

namespace App\Exports\Risk;

use App\Models\Risk\Assessment\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as WorksheetExcel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class WorksheetInherentExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected array $headers = [
        'No.',
        'Nama Perusahaan',
        'Kode Perusahaan',
        'No. Risiko',
        'Peristiwa Risiko',
        'Risiko Inheren'
    ];

    protected array $nested_columns = [
        'Risiko Inheren' => [
            'Asumsi Perhitungan Dampak',
            'Nilai Dampak',
            'Skala Dampak',
            'Nilai Probabilitas',
            'Skala Probabilitas',
            'Eksposur Risiko',
            'Skala Risiko',
            'Level Risiko'
        ],
    ];

    protected array $merged_cells = [];

    protected int $count = 0;


    public function __construct(public Worksheet $worksheet) {}

    public function collection()
    {
        return collect($this->worksheet->target->identification->incidents)->map(function ($incident, $index) {
            $residuals = $this->worksheet->target->identification->residuals;
            $residualData = [];
            $this->count += 1;

            // Process residual data
            for ($i = 0; $i < 7; $i++) {
                for ($j = 0; $j < count($residuals); $j++) {
                    if ($i == 0 || $i == 4) {
                        $residualData[] = money_format((float) $residuals[$j][$i]);
                    } else {
                        $residualData[] = $residuals[$j][$i];
                    }
                }
            }

            return [
                'No.' => $index + 1,
                'Nama Perusahaan' => $this->worksheet->company_name,
                'Kode Perusahaan' => $this->worksheet->company_code,
                'No. Risiko' => $this->worksheet->worksheet_number,
                'Peristiwa Risiko' => strip_html($incident->risk_chronology_body),
                'Asumsi Perhitungan Dampak' => strip_html($this->worksheet->target->identification->inherent->body),
                'Nilai Dampak' =>
                $this->worksheet->target->identification->risk_impact_category == 'kuantitatif' ?
                    money_format((float) $this->worksheet->target->identification->inherent->impact_value) : '-',
                'Skala Dampak' => $this->worksheet->target->identification->inherent->impact_scale?->scale,
                'Nilai Probabilitas' => $this->worksheet->target->identification->inherent->impact_probability,
                'Skala Probabilitas' => $this->worksheet->target->identification->inherent->impact_probability_scale?->risk_scale,
                'Eksposur Risiko' => money_format((float) $this->worksheet->target->identification->inherent->risk_exposure ?? '0'),
                'Skala Risiko' => $this->worksheet->target->identification->inherent->risk_scale,
                'Level Risiko' => $this->worksheet->target->identification->inherent->risk_level,
            ];
        });
    }

    public function headings(): array
    {
        [$this->headers, $this->merged_cells] = excel_build_nested_headers($this->headers, $this->nested_columns);
        return $this->headers;
    }

    public function styles(WorksheetExcel $sheet)
    {
        $lastColumn = $this->getLastColumn(count($this->headers[0]));

        // Style for headers
        $sheet->getStyle("A1:{$lastColumn}2")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1896A4']
            ],
        ]);

        $sheet->getStyle("A1:{$lastColumn}" . ($this->count + 2))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $colors = ['00B050', 'FFFF00', 'FF0000',];
        // Auto-size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Merge nested column headers
        foreach ($this->merged_cells as $merge) {
            $startCol = $this->getColumnLetter($merge['start']);
            $endCol = $this->getColumnLetter($merge['start'] + $merge['count'] - 1);

            if ($merge['parent']) {
                // Merge parent cell (row 1)
                $sheet->mergeCells("{$startCol}1:{$endCol}1");
                // Add children in row 2
                for ($i = 0; $i < $merge['count']; $i++) {
                    $col = $this->getColumnLetter($merge['start'] + $i);
                    $value = $this->nested_columns[$merge['parent']][$i];
                    $sheet->setCellValue(
                        "{$col}2",
                        $value
                    );
                }

                // Style for headers
                $sheet->getStyle("{$startCol}2:{$endCol}2")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D8D8D8']
                    ]
                ]);
                continue;
            }
            // Merge row (row 1)
            $sheet->mergeCells("{$startCol}1:{$startCol}2");
        }

        // Merge cells with same values for specific columns
        excel_merge_same_values(
            $sheet,
            [
                'B',
                'C',
                'D',
                'G',
                'H',
                'I',
                'J',
                'J',
                'K',
                'L',
                'M'
            ], // Columns to merge - adjust as needed
            3, // Start from row 3 (after headers)
            $this->count + 2
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
        return 'Risiko Inheren ' . ucwords($this->worksheet->target->identification->risk_impact_category);
    }
}
