<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Soundasleep\Html2Text;

class MonitoringResidualExport implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnFormatting
{
    protected array $headers = [
        'Data Item',
        'Peristiwa Risiko',
        'Asumsi Perhitungan Dampak',
        'Nilai Dampak',
        'Skala Dampak',
        'Nilai Probabilitas',
        'Skala Probabilitas',
        'Nilai Eksposur Risiko',
        'Skala Nilai Risiko',
        'Level Risiko',
        'Efektifitas Perlakuan Risiko',
    ];

    protected array $nested_columns = [
        'Nilai Dampak' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Skala Dampak' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Nilai Probabilitas' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Skala Probabilitas' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Nilai Eksposur Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Skala Nilai Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
        'Level Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
    ];

    protected array $merged_cells = [];

    protected int $count = 0;

    public function __construct(private Collection $worksheets) {}

    public function collection()
    {
        $data = [];
        $residuals = [];
        foreach ($this->worksheets as $worksheet) {
            foreach ($worksheet->monitorings as $monitoring) {
                $residualDefault = [
                    'impact_value' => array_fill(1, 4, '-'),
                    'impact_scale' => array_fill(1, 4, '-'),
                    'impact_probability_value' => array_fill(1, 4, '-'),
                    'impact_probability_scale' => array_fill(1, 4, '-'),
                    'risk_exposure' => array_fill(1, 4, '-'),
                    'risk_scale' => array_fill(1, 4, '-'),
                    'risk_level' => array_fill(1, 4, '-'),
                ];

                $residual = $monitoring->residual;
                $residualKey = $worksheet->worksheet_number . $residual->worksheet_incident_id;
                if (!array_key_exists($residualKey, $residuals)) {
                    $residuals[$residualKey] = $residualDefault;
                }

                $item = $residuals[$residualKey];
                $item = array_merge([
                    'worksheet_number' => $worksheet->worksheet_number,
                    'risk_chronology_body' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($worksheet->identification->risk_chronology_body))),
                    'inherent_body' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($worksheet->identification->inherent_body))),
                ], $item);
                $item['impact_value'][$residual->quarter] = $residual->impact_value ? money_format((float) $residual->impact_value) : '-';
                $item['impact_scale'][$residual->quarter] = $residual->impact_scale?->scale;
                $item['impact_probability_value'][$residual->quarter] = $residual->impact_probability ?? '-';
                $item['impact_probability_scale'][$residual->quarter] = $residual->impact_probability_scale?->risk_scale ?? '-';
                $item['risk_exposure'][$residual->quarter] = $residual->risk_exposure ? money_format((float) $residual->risk_exposure) : '-';
                $item['risk_scale'][$residual->quarter] = $residual?->impact_probability_scale?->risk_scale ?? '-';
                $item['risk_level'][$residual->quarter] = $residual?->impact_probability_scale?->risk_level ?? '-';
                $item['risk_mitigation_effectiveness'] = $residual->risk_mitigation_effectiveness == null ? '-' : ($residual->risk_mitigation_effectiveness ? 'Ya' : 'Tidak');
                $residuals[$residualKey] = $item;
            }
        }

        foreach ($residuals as $residual) {
            $data[] = [
                'worksheet_number' => $residual['worksheet_number'],
                'risk_chronology_body' => $residual['risk_chronology_body'],
                'inherent_body' => $residual['inherent_body'],
                ...array_values($residual['impact_value']),
                ...array_values($residual['impact_scale']),
                ...array_values($residual['impact_probability_value']),
                ...array_values($residual['impact_probability_scale']),
                ...array_values($residual['risk_exposure']),
                ...array_values($residual['risk_scale']),
                ...array_values($residual['risk_level']),
                'risk_mitigation_effectiveness' => $residual['risk_mitigation_effectiveness'],
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        [$this->headers, $this->merged_cells] = excel_build_nested_headers($this->headers, $this->nested_columns);
        return $this->headers;
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = $this->getLastColumn(count($this->headers[0]));

        // Style for headers
        $sheet->getStyle("A1:{$lastColumn}2")->applyFromArray([
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


        // Auto-size columns
        $alphabets = range('A', 'Z');
        $break = false;
        foreach ($alphabets as $alphabet) {
            foreach ($alphabets as $alphabet2) {
                $value = $alphabet . $alphabet2;
                $alphabets[] = $value;

                if ($lastColumn == $value) {
                    $break = true;
                    break;
                }
            }

            if ($break) break;
        }
        foreach ($alphabets as $column) {
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
                'A',
            ], // Columns to merge - adjust as needed
            3, // Start from row 3 (after headers)
            $this->count
        );

        for ($i = 3; $i <= $this->count + 2; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(-1);
        }

        $sheet->getStyle("A1:{$lastColumn}" . $this->count + 2)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle('B3:C' . ($this->count + 2))
            ->getAlignment()
            ->setWrapText(true);
        $sheet->getStyle("A3:{$lastColumn}" . $this->count + 2)
            ->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
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
        return 'Realisasi Risiko Residual';
    }
}
