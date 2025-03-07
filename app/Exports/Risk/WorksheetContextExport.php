<?php

namespace App\Exports\Risk;

use App\Models\Risk\Assessment\Worksheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
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
    protected string $lastColumn;

    public function __construct(private Collection $worksheets) {}

    public function collection()
    {
        $currentIndex = 0;
        $data = $this->worksheets->map(function ($worksheet) use (&$currentIndex) {
            return $worksheet->incidents->map(function ($incident) use ($worksheet, &$currentIndex) {
                $currentIndex += 1;
                return [
                    'No.' => $currentIndex,
                    'Nama Perusahaan' => $worksheet->company_name,
                    'Kode Perusahaan' => $worksheet->company_code,
                    'Sasaran Perusahaan' => strip_html($worksheet->target_body),
                    'Kategori Risiko' => $worksheet->identification->risk_category_t2_name . ' & ' . $worksheet->identification->risk_category_t3_name,
                    'No. Risiko' => $worksheet->worksheet_number,
                    'Peristiwa Risiko' => strip_html($worksheet->identification->risk_chronology_body),
                    'Deskripsi Peristiwa Risiko' => strip_html($worksheet->identification->risk_chronology_description),
                    'No. Penyebab Risiko' => $incident->risk_cause_number,
                    'Kode Penyebab Risiko' => $incident->risk_cause_code,
                    'Penyebab Risiko' => strip_html($incident->risk_cause_body),
                    'Key Risk Indicators' => $incident->kri_body,
                    'Unit Satuan KRI' => $incident->kri_unit?->name,
                    'Aman' => $incident->kri_threshold_safe,
                    'Hati-Hati' => $incident->kri_threshold_caution,
                    'Bahaya' => $incident->kri_threshold_danger,
                    'Jenis Existing Control' => $worksheet->identification->existing_control_type_name,
                    'Existing Control' => strip_html($worksheet->identification->existing_control_body),
                    'Penilaian Efektivitas Kontrol' => $worksheet->identification->control_effectiveness_assessment_name,
                    'Kategori Dampak' => $worksheet->identification->risk_impact_category,
                    'Deskripsi Dampak' => strip_html($worksheet->identification->risk_impact_body),
                    'Perkiraan Waktu' => format_date($worksheet->identification->risk_impact_start_date)->translatedFormat('M') . '-' . format_date($worksheet->identification->risk_impact_end_date)->translatedFormat('M'),
                ];
            });
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

        $colors = ['00B050', 'FFFF00', 'FF0000',];
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

        $columnWidths = [
            'A' => 8,
            'B' => 36,
            'C' => 18,
            'D' => 54,
            'E' => 36,
            'F' => 18,
            'G' => 54,
            'H' => 54,
            'I' => 12,
            'J' => 18,
            'K' => 54,
            'L' => 36,
            'M' => 36,
            'N' => 42,
            'Q' => 36,
            'R' => 54,
            'S' => 36,
            'T' => 24,
            'U' => 54,
            'V' => 30,
        ];

        foreach (range('A', $this->lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidths[$column] ?? 18);
        }

        // // Merge cells with same values for specific columns
        // excel_merge_same_values(
        //     $sheet,
        //     [
        //         'B',
        //         'C',
        //         'D',
        //         'E',
        //         'F',
        //         'L',
        //         'M',
        //         'N',
        //         'O',
        //         'P',
        //         'Q',
        //         'R',
        //         'S',
        //         'T',
        //         'U',
        //         'V',
        //     ], // Columns to merge - adjust as needed
        //     3, // Start from row 3 (after headers)
        //     $this->count
        // );

        $sheet->getStyle("A1:{$this->lastColumn}{$this->count}")->applyFromArray([
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {}
        ];
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
