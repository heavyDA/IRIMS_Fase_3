<?php

namespace App\Exports\Risk;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Mews\Purifier\Facades\Purifier;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorksheetLossEventExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected array $headers = [
        'No.',
        'Unit',
        'Sasaran Perusahaan',
        'Profil Risiko',
        'Peristiwa Risiko',
        'Waktu Kejadian',
        'Sumber Penyebab Kejadian',
        'Perlakuan atas Kejadian',
        'Kategori Risiko',
        'Nilai Kerugian',
        'Pihak Terkait',
        'Status Pemulihan Saat Ini',
        'Status Asuransi',
        'Nilai Premi',
        'Nilai Klaim'
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
                    'unit' => "[{$alteration->sub_unit_code_doc}] {$alteration->sub_unit_name}",
                    'target_body' => strip_html(Purifier::clean($alteration->target_body ?? '')),
                    'incident_body' => strip_html(Purifier::clean($alteration->incident_body ?? '')),
                    'incident_date' => strip_html(Purifier::clean($alteration->incident_date ?? '')),
                    'incident_source' => strip_html(Purifier::clean($alteration->incident_source ?? '')),
                    'incident_handling' => strip_html(Purifier::clean($alteration->incident_handling ?? '')),
                    'risk_category_t2_id' => strip_html(Purifier::clean($alteration->risk_category_t2_id ?? '')),
                    'risk_category_t3_id' => strip_html(Purifier::clean($alteration->risk_category_t3_id ?? '')),
                    'loss_value' => money_format((float) $alteration->loss_value ?? 0),
                    'related_party' => strip_html(Purifier::clean($alteration->related_party ?? '')),
                    'restoration_status' => strip_html(Purifier::clean($alteration->restoration_status ?? '')),
                    'insurance_status' => $alteration->insurance_status ? 'Ya' : 'Tidak',
                    'insurance_permit' => money_format((float) $alteration->insurance_permit ?? 0),
                    'insurance_claim' => money_format((float) $alteration->insurance_claim ?? 0),
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
            'C' => 40,
            'D' => 48,
            'E' => 48,
            'F' => 32,
            'G' => 48,
            'H' => 32,
            'I' => 32,
            'J' => 48,
            'K' => 48,
            'L' => 48,
            'M' => 48,
            'N' => 32,
            'O' => 32,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $count = $this->alterations->count() + 1;

        $styles = [
            'A1:O1' => [
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
            $styles["A2:O{$count}"] = [
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
            $sheet->mergeCells("C{$startRow}:C{$lastRow}");
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
        return 'Loss Event Database';
    }
}
