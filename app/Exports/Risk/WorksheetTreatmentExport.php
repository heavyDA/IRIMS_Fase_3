<?php

namespace App\Exports\Risk;

use App\Models\Risk\Assessment\Worksheet;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as WorksheetExcel;

class WorksheetTreatmentExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected array $headers = [
        'No.',
        'Nama Perusahaan',
        'Kode Perusahaan',
        'No. Risiko',
        'No. Penyebab Risiko',
        'Penyebab Risiko',
        'Opsi Perlakuan Risiko',
        'Jenis Rencana Perlakuan Risiko',
        'Rencana Perlakuan Risiko',
        'Output Perlakuan Risiko',
        'Biaya Perlakuan Risiko',
        'Jenis Program Dalam RKAP',
        'PIC',
        'Timeline (Bulan)',
    ];

    protected array $nested_columns = [];

    protected array $merged_cells = [];

    protected int $count = 0;

    protected string $lastColumn;

    public function __construct(public Collection $worksheets)
    {
        $this->nested_columns = [
            'Timeline (Bulan)' =>  range(1, 12)
        ];
    }

    public function collection()
    {
        $currentIndex = 0;
        $data = [];
        $this->worksheets->each(function ($worksheet) use (&$currentIndex, &$data) {
            $worksheet->incidents->each(function ($incident) use ($worksheet, &$currentIndex, &$data) {
                $incident->mitigations->each(function ($mitigation) use ($worksheet, $incident, &$currentIndex, &$data) {
                    $currentIndex += 1;
                    $item = [
                        'No.' => $currentIndex,
                        'Nama Perusahaan' => $worksheet->company_name,
                        'Kode Perusahaan' => $worksheet->company_code,
                        'No. Risiko' => $worksheet->worksheet_number,
                        'No. Penyebab Risiko' => $incident->risk_cause_number,
                        'Penyebab Risiko' => strip_html($incident->risk_cause_body),
                        'Opsi Perlakuan Risiko' => $mitigation->risk_treatment_option?->name ?? '-',
                        'Jenis Rencana Perlakuan Risiko' => $mitigation->risk_treatment_type?->name ?? '-',
                        'Rencana Perlakuan Risiko' => strip_html($mitigation->mitigation_plan),
                        'Output Perlakuan Risiko' => strip_html($mitigation->mitigation_output),
                        'Biaya Perlakuan Risiko' => money_format((float) $mitigation->mitigation_cost ?? '0'),
                        'Jenis Program Dalam RKAP' => $mitigation->rkap_program_type?->name ?? '-',
                        'PIC' => $mitigation->mitigation_pic,
                    ];

                    $months = array_keys(range(1, 12));
                    $start = format_date($mitigation->mitigation_start_date)->month;
                    $end = format_date($mitigation->mitigation_end_date)->month;

                    foreach ($months as $key => $value) {
                        $months[$key] = $start >= $value && $value <= $end ? 1 : '0';
                    }

                    $data[] = array_merge($item, $months);
                });
            });
        });

        $this->count = $currentIndex + 2;
        return collect($data);
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
            'E' => 18,
            'F' => 54,
            'G' => 36,
            'H' => 42,
            'I' => 54,
            'J' => 54,
            'K' => 36,
            'L' => 36,
            'M' => 36,
            'N' => 6,
            'O' => 6,
            'P' => 6,
            'Q' => 6,
            'R' => 6,
            'S' => 6,
            'T' => 6,
            'U' => 6,
            'V' => 6,
            'W' => 6,
            'X' => 6,
            'Y' => 6,
        ];

        foreach (range('A', $this->lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidths[$column] ?? 18);
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
                'M',
            ], // Columns to merge - adjust as needed
            3, // Start from row 3 (after headers)
            $this->count
        );

        $sheet->getStyle("A1:{$this->lastColumn}" . ($this->count))->applyFromArray([
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
        return 'Rencana Perlakuan Risiko';
    }
}
