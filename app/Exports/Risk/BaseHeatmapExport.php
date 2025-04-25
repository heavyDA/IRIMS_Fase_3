<?php

namespace App\Exports\Risk;

use App\Models\Master\Heatmap;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

abstract class BaseHeatmapExport implements FromArray, WithTitle, WithEvents, WithDrawings
{
    public $heatmaps;
    private array $drawings;
    private array $alphabets;
    private array $rows = [23, 18, 13, 8, 3];
    private array $cols = [4, 9, 14, 19, 24];

    public function __construct(private $worksheets = [])
    {
        $this->heatmaps = Heatmap::orderBy('impact_probability', 'desc')
            ->orderBy('risk_scale', 'asc')
            ->get();

        $alphabets = range('a', 'z');

        $this->alphabets = array_merge(
            $alphabets,
            array_map(fn($value) => 'a' . $value, range('a', 'z'))
        );
    }

    public function array(): array
    {
        return [];
    }

    public function drawings(): array
    {
        $coordinates = [];

        foreach ($this->worksheets as $worksheet) {
            $startCol = $this->alphabets[$this->cols[$worksheet->impact_scale - 1]];
            $row = $this->rows[$worksheet->impact_probability - 1];
            $coordinate = "{$startCol}{$row}";

            if (array_key_exists($worksheet->risk_scale, $coordinates)) {
                $count = count($coordinates[$worksheet->risk_scale]);
                $startCol = $this->alphabets[$this->cols[$worksheet->impact_scale - 1] + ($count % 5)];
                $row = $this->rows[$worksheet->impact_probability - 1];
                $row += floor($count / 5);

                $coordinate = "{$startCol}{$row}";
                $coordinates[$worksheet->risk_scale][] = $coordinate;
            } else {
                $coordinates[$worksheet->risk_scale] = [$coordinate];
            }

            $color = $worksheet->risk_type == 'inherent' ? HeatmapPointDrawing::INHERENT_COLOR : HeatmapPointDrawing::RESIDUAL_COLOR;

            $drawing = new HeatmapPointDrawing();
            $this->drawings[] = $drawing->make(value: $worksheet->worksheet_id, label: $worksheet->worksheet_id, color: $color, coordinate: $coordinate);
        }

        return empty($this->drawings) ? [new Drawing()] : $this->drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->setShowGridlines(false);

                for ($row = 1; $row < 100; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(42);
                }

                $probabilities = [
                    'Hampir Pasti Terjadi',
                    'Sangat Mungkin Terjadi',
                    'Bisa Terjadi',
                    'Jarang Terjadi',
                    'Sangat Jarang Terjadi',
                ];

                $impacts = [
                    'Sangat Rendah',
                    'Rendah',
                    'Moderat',
                    'Tinggi',
                    'Sangat Tinggi',
                ];

                foreach ($probabilities as $key => $text) {
                    $row = (3 + ($key * 5));

                    $sheet->mergeCells("C{$row}:C" . ($row + 4));
                    $sheet->mergeCells("D{$row}:D" . ($row + 4));
                    $sheet->getCell("C{$row}")->setValue($text);
                    $sheet->getCell("D{$row}")->setValue($key + 1);
                }

                $sheet->getStyle('C3:D27')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);
                $sheet->getStyle('D3:D27')->applyFromArray(['font' => ['bold' => true]]);

                foreach ($impacts as $key => $text) {
                    $col = 4 + ($key * 5);
                    $startCol = $this->alphabets[$col];
                    $endCol = $this->alphabets[$col + 4];

                    for ($row = 3; $row < 27; $row++) {
                        $endRow = $row + 4;
                        $sheet->mergeCells("{$startCol}{$row}:{$endCol}{$endRow}");
                        $row = $endRow;
                    }

                    $sheet->mergeCells("{$startCol}28:{$endCol}28");
                    $sheet->mergeCells("{$startCol}29:{$endCol}29");
                    $sheet->getCell($this->alphabets[$col] . '28')->setValue($key + 1);
                    $sheet->getCell($this->alphabets[$col] . '29')->setValue($text);
                }

                $sheet->getStyle('E28:AC30')
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000']
                            ]
                        ],
                    ])
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);

                //

                $sheet->mergeCells('B3:B27');
                $sheet->getCell('B3')->setValue('Tingkat Kemungkinan');
                $sheet->getStyle('B3')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('B3:B27')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true)
                    ->setTextRotation(90);

                $sheet->mergeCells('E30:AC30');
                $sheet->getCell('E30')->setValue('Tingkat Dampak');
                $sheet->getStyle('E28:AC28')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('E30:AC30')->applyFromArray(['font' => ['bold' => true]]);
                $sheet->getStyle('E30:AC30')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);
                $sheet->getStyle('B3:AC27')
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000']
                            ]
                        ],
                    ]);

                foreach ($this->alphabets as $col) {
                    $dimension = $sheet->getColumnDimension($col);
                    if ($col == 'b') {
                        $dimension->setWidth(9);
                    } else if ($col == 'c') {
                        $dimension->setWidth(21);
                    } else {
                        $dimension->setWidth(8);
                    }
                }

                foreach ($this->heatmaps as $key => $heatmap) {
                    $startCol = $this->alphabets[$this->cols[$heatmap->impact_scale - 1]];
                    $endCol = $this->alphabets[($this->cols[$heatmap->impact_scale - 1]) + 4];

                    $startRow = $this->rows[$heatmap->impact_probability - 1];
                    $endRow = $startRow + 4;
                    $sheet->getCell("{$startCol}{$startRow}")->setValue("{$heatmap->risk_level}\n{$heatmap->risk_scale}");

                    $style = [
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => str_replace('#', '', $heatmap->color)]]
                    ];

                    if ($heatmap->risk_scale == 'Low') {
                        $style['font'] = ['color' => ['argb' => 'FFFFFF']];
                    }
                    $sheet->getStyle("{$startCol}{$startRow}:{$endCol}{$endRow}")
                        ->applyFromArray($style)
                        ->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setWrapText(true);
                }
            }
        ];
    }

    public function title(): string
    {
        return 'Heatmap';
    }
}
