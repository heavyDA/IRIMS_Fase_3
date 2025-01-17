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

class WorksheetContextExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected array $headers = [
        'No.',
        'Nama Perusahaan',
        'Kode Perusahaan',
        'Sasaran Perusahaan',
        'Kategori Risiko T2 & T3',
        'No. Risiko',
        'Peristiwa Risiko',
        'Deskripsi Peristiwa Risiko',
        'No. Penyebab Risiko',
        'Kode Penyebab Risiko',
        'Penyebab Risiko',
        'Key Risk Indicators',
        'Unit Satuan KRI',
        'Kategori Threshold KRI',
        'Jenis Existing Control',
        'Existing Control',
        'Penilaian Efektivitas Kontrol',
        'Kategori Dampak',
        'Deskripsi Dampak',
        'Perkiraan Waktu Terpapar Risiko',
    ];

    protected array $nested_columns = [
        'Kategori Threshold KRI' => ['Aman', 'Hati-Hati', 'Bahaya'],
    ];

    protected array $merged_cells = [];

    protected int $count = 0;

    public function __construct(public Worksheet $worksheet) {}

    public function collection()
    {
        return collect($this->worksheet->target->identification->incidents)->map(function ($incident, $index) {
            $this->count += 1;

            $residuals = $this->worksheet->target->identification->residuals;
            $residualData = [];
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
                'Sasaran Perusahaan' => strip_html($this->worksheet->target->body),
                'Kategori Risiko' => $this->worksheet->target->identification->risk_category_t2->name . ' & ' . $this->worksheet->target->identification->risk_category_t3->name,
                'No. Risiko' => $this->worksheet->worksheet_number,
                'Peristiwa Risiko' => strip_html($incident->risk_chronology_body),
                'Deskripsi Peristiwa Risiko' => strip_html($incident->risk_chronology_description),
                'No. Penyebab Risiko' => $incident->risk_cause_number,
                'Kode Penyebab Risiko' => $incident->risk_cause_code,
                'Penyebab Risiko' => strip_html($incident->risk_cause_body),
                'Key Risk Indicators' => $incident->kri_body,
                'Unit Satuan KRI' => $incident->kri_unit?->name,
                'Aman' => $incident->kri_threshold_safe,
                'Hati-Hati' => $incident->kri_threshold_caution,
                'Bahaya' => $incident->kri_threshold_danger,
                'Jenis Existing Control' => $this->worksheet->target->identification->existing_control_type->name,
                'Existing Control' => strip_html($this->worksheet->target->identification->existing_control_body),
                'Penilaian Efektivitas Kontrol' => $this->worksheet->target->identification->control_effectiveness_assessment->name,
                'Kategori Dampak' => $this->worksheet->target->identification->risk_impact_category,
                'Deskripsi Dampak' => strip_html($this->worksheet->target->identification->risk_impact_body),
                'Perkiraan Waktu' => $this->worksheet->target->identification->format_risk_start_date->translatedFormat('M') . '-' . $this->worksheet->target->identification->format_risk_end_date->translatedFormat('M'),
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

                    if (in_array($value, ['Aman', 'Hati-Hati', 'Bahaya'])) {
                        // Style for headers
                        $sheet->getStyle("{$col}2")->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['rgb' => $value == 'Hati-Hati' ? '000000' : 'FFFFFF']],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => $colors[$i]]
                            ]
                        ]);
                    }

                    $sheet->setCellValue(
                        "{$col}2",
                        $value
                    );
                }
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
                'E',
                'F',
                'L',
                'M',
                'N',
                'O',
                'P',
                'Q',
                'R',
                'S',
                'T',
                'U',
                'V',
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
        return 'Profil Risiko';
    }
}
