<?php

namespace App\Exports\Risk;

use App\Models\Risk\Assessment\Worksheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as WorksheetExcel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class WorksheetResidualExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected array $headers = [
        'No.',
        'Nama Perusahaan',
        'Kode Perusahaan',
        'No. Risiko',
        'Peristiwa Risiko',
        'Nilai Dampak',
        'Skala Dampak',
        'Nilai Probabilitas',
        'Skala Probabilitas',
        'Eksposur Risiko',
        'Skala Risiko',
        'Level Risiko',
    ];

    protected array $nested_columns = [
        'Nilai Dampak' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Skala Dampak' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Nilai Probabilitas' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Skala Probabilitas' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Eksposur Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Skala Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Level Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
    ];

    protected array $merged_cells = [];

    protected int $count = 0;

    protected string $lastColumn;

    public function __construct(private Collection $worksheets, public string $impact_category = 'kuantitatif') {}

    public function collection()
    {
        $data = $this->worksheets->filter(fn($worksheet) => $worksheet->identification->risk_impact_category == $this->impact_category)
            ->map(function ($worksheet) use (&$currentIndex) {
                $currentIndex += 1;
                $item = [
                    'No.' => $currentIndex,
                    'Nama Perusahaan' => $worksheet->company_name,
                    'Kode Perusahaan' => $worksheet->company_code,
                    'No. Risiko' => $worksheet->worksheet_number,
                    'Peristiwa Risiko' => strip_html($worksheet->identification->risk_chronology_body),
                ];

                foreach (
                    [
                        'impact_value',
                        'impact_scale',
                        'impact_probability',
                        'impact_probability_scale',
                        'risk_exposure',
                        'risk_scale',
                        'risk_level',
                    ] as $key
                ) {
                    for ($i = 1; $i <= 4; $i++) {

                        $_key = "residual_{$i}_{$key}";
                        if (str_contains($_key, 'impact_value') || str_contains($_key, 'risk_exposure')) {
                            $item[$_key] = $worksheet->identification->$_key ? money_format((float) $worksheet->identification->$_key) : '-';
                        } else {
                            $item[$_key] = $worksheet->identification->$_key ?? '-';
                        }
                    }
                }

                return $item;
            });

        $this->count = $currentIndex + 2;
        return $data;
    }

    public function headings(): array
    {
        [$this->headers, $this->merged_cells] = excel_build_nested_headers($this->headers, $this->nested_columns);
        return $this->headers;
    }

    public function styles(WorksheetExcel $sheet)
    {
        $this->lastColumn = $this->getLastColumn(count($this->headers[0]));

        // Style for headers
        $sheet->getStyle("A1:{$this->lastColumn}2")->applyFromArray([
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

        // Auto-size columns
        $alphabets = range('A', 'Z');
        $break = false;
        foreach ($alphabets as $alphabet) {
            foreach ($alphabets as $alphabet2) {
                $value = $alphabet . $alphabet2;
                $alphabets[] = $value;

                if ($this->lastColumn == $value) {
                    $break = true;
                    break;
                }
            }

            if ($break) break;
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

        $columnWidths = [
            'A' => 8,
            'B' => 36,
            'C' => 18,
            'D' => 18,
            'E' => 54,
            'F' => 36,
            'G' => 36,
            'H' => 36,
            'I' => 36,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 12,
            'O' => 12,
            'P' => 12,
            'Q' => 12,
            'R' => 12,
            'S' => 12,
            'T' => 12,
            'U' => 12,
            'V' => 36,
            'W' => 36,
            'X' => 36,
            'Y' => 36,
            'Z' => 12,
            'AA' => 12,
            'AB' => 12,
            'AC' => 12,
            'AD' => 20,
            'AE' => 20,
            'AF' => 20,
            'AG' => 20,
        ];

        foreach ($alphabets as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidths[$column] ?? 18);
        }

        // Merge cells with same values for specific columns
        $merged_rows = [
            'B',
            'C',
        ];

        if ($this->impact_category == 'kuantitatif') {
            $merged_rows = array_merge($merged_rows, array_slice($alphabets, 5, array_search($this->lastColumn, $alphabets)));
        }

        excel_merge_same_values(
            $sheet,
            $merged_rows, // Columns to merge - adjust as needed
            3, // Start from row 3 (after headers)
            $this->count
        );

        $sheet->getStyle("A1:{$this->lastColumn}" . $this->count)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle("A1:{$this->lastColumn}2")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("{$column}3:{$this->lastColumn}{$this->count}")
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
        return 'Risiko Residual ' . ucwords($this->impact_category);
    }
}
