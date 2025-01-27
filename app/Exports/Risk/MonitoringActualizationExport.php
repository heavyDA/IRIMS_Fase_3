<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet as WorksheetExcel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class MonitoringActualizationExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected array $headers = [
        'Data Item',
        'Peristiwa Risiko',
        'Tanggal',
        'Realisasi Rencana Perlakuan Risiko',
        'Realisasi Output atas masing-masing Breakdown Perlakuan Risiko',
        'Realisasi Biaya Perlakuan Risiko',
        'Persentase Serapan Biaya',
        'PIC',
        'PIC Terkait',
        'Realisasi Timeline',
        'Key Risk Indicators',
        'Realisasi KRI Threshold',
        'Status Rencana Perlakuan Risiko',
        'Penjelasan Status Rencana Perlakuan Risiko',
        'Progress Pelaksanaan Rencana Perlakuan Risiko',
    ];

    protected array $nested_columns = [];

    protected array $merged_cells = [];

    protected int $count = 0;

    public function __construct(private Collection $worksheets)
    {
        $this->nested_columns = [
            'Realisasi Timeline' => range(1, 12),
            'Realisasi KRI Threshold' => ['Threshold', 'Skor'],
            'Progress Pelaksanaan Rencana Perlakuan Risiko' => ['Q1', 'Q2', 'Q3', 'Q4'],
        ];
    }

    public function collection()
    {
        $currentIndex = 0;
        $data = [];
        $this->worksheets->map(function ($worksheet) use (&$currentIndex, &$data) {
            $timeline = array_fill(0, 12, '0');
            foreach ($worksheet->monitorings as $monitoring) {
                $month = format_date($monitoring->period_date)->month - 1;
                if (array_key_exists($month, $timeline)) {
                    $timeline[$month] = 1;
                }
            }

            $plan_progress = [];
            foreach ($worksheet->monitorings as $monitoring) {
                foreach ($monitoring->actualizations as $actualization) {
                    $plan_progress[$actualization->worksheet_mitigation_id] = array_fill(0, 4, 0);
                    if ($actualization->actualization_plan_progress) {
                        $plan_progress[$actualization->worksheet_mitigation_id][$actualization->quarter - 1] = $actualization->actualization_plan_progress;
                    }
                }
            }

            return $worksheet->monitorings->map(function ($monitoring) use ($worksheet, &$currentIndex, $timeline, &$data, $plan_progress) {
                $monitoring->period_date = format_date($monitoring->period_date)->translatedFormat('d M Y');
                return $monitoring->actualizations->map(function ($actualization) use ($worksheet, $monitoring, &$currentIndex, $timeline, &$data, $plan_progress) {
                    $currentIndex += 1;
                    $item = [
                        'No. Risiko' => $worksheet->worksheet_number,
                        'Peristiwa Risiko' => strip_html($worksheet->identification->risk_chronology_body),
                        'Tanggal' => $monitoring->period_date,
                        'Realisasi Rencana Perlakuan Risiko' => strip_html($actualization->actualization_plan_body),
                        'Realisasi Output atas masing-masing Breakdown Perlakuan Risiko' => strip_html($actualization->actualization_plan_output),
                        'Realisasi Biaya Perlakuan Risiko' => $actualization->actualization_cost ? money_format((float) $actualization->actualization_cost) : '',
                        'Persentase Serapan Biaya' => $actualization->actualization_cost_absorption ? $actualization->actualization_cost_absorption . '%' : '',
                        'PIC' => $actualization->mitigation->mitigation_pic,
                        'PIC Terkait' => $actualization->unit_code ? "[{$actualization->personnel_area_code}] {$actualization->position_name}" : '',
                        ...$timeline,
                        'Key Risk Indicators' => strip_html($actualization->mitigation->incident->kri_body),
                        'Realisasi KRI Threshold' => $actualization->kri_threshold,
                        'Realisasi KRI Threshold Skor' => $actualization->kri_threshold_score,
                        'Status Rencana Perlakuan Risiko' => $actualization->actualization_plan_status,
                        'Penjelasan Status Rencana Perlakuan Risiko' => $actualization->actualization_plan_explanation,
                        ...array_values($plan_progress[$actualization->worksheet_mitigation_id]),
                    ];

                    $data[] = $item;
                    return $item;
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

        $colors = ['00B050', 'FFFF00', 'FF0000',];
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
                'A',
                'B',
                'C',
                'D',
                'E',
                'H',
                'I',
                'F',
                'V',
                'AA',
                'AB',
                'AC',
                'AD',
            ], // Columns to merge - adjust as needed
            3, // Start from row 3 (after headers)
            $this->count
        );

        $sheet->getStyle("A1:{$lastColumn}" . ($this->count))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle('A3:A' . $this->count)->applyFromArray([
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                for ($row = 3; $row < $this->count + 1; $row++) {

                    $timeline = [];
                    $timelineStart = '';
                    $timelineEnd = '';

                    $previousCellValue = '';
                    foreach (range('J', 'U') as $key => $alphabet) {
                        $cellValue = $event->sheet->getCell($alphabet . $row)->getValue();

                        if ($timelineStart == '' && $cellValue == '1') {
                            $timelineStart = $alphabet . $row;
                            $timelineEnd = $timelineStart;
                        }

                        if ($cellValue == '1') {
                            if ($previousCellValue != $cellValue) {
                                $timeline[] = "{$timelineStart}:{$timelineEnd}";

                                $timelineStart = $alphabet . $row;
                                $timelineEnd = $timelineStart;
                            }
                        }

                        if ($cellValue == '1') {
                            $timelineEnd = $alphabet . $row;
                        }

                        if ($alphabet == 'U') {
                            $timeline[] = "{$timelineStart}:{$timelineEnd}";
                        }

                        $previousCellValue = $cellValue;
                    }

                    foreach (array_unique($timeline) as $cellRange) {
                        $event->sheet->getStyle($cellRange)
                            ->applyFromArray([
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => '92F18B']
                                ]
                            ]);
                    }
                }
            }
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
        return 'Realisasi Perlakuan Risiko';
    }
}
