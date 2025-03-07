<?php

namespace App\Exports\Risk;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Soundasleep\Html2Text;

class MonitoringIncidentExport implements FromCollection, WithTitle, WithStyles, WithHeadings
{
    protected array $headers = [
        'Data Item',
        'Nama Kejadian',
        'Identifikasi Kejadian ',
        'Kategori Kejadian',
        'Sumber Penyebab Kejadian',
        'Penyebab Kejadian',
        'Penanganan saat Kejadian',
        'Deskripsi Kejadian - Risk Event',
        'Kategori Risiko Perusahaan',
        'Penjelasan Kerugian',
        'Nilai Kerugian',
        'Kejadian Berulang',
        'Frekuensi Kejadian',
        'Mitigasi yang Direncanakan',
        'Realisasi Mitigasi',
        'Perbaikan Mendatang',
        'Pihak terkait',
        'Status Asuransi',
        'Nilai Premi',
        'Nilai Klaim',
    ];

    protected array $nested_columns = [];

    protected array $merged_cells = [];

    protected string $lastColumn = '';

    protected int $count = 0;

    public function __construct(private Collection $worksheets) {}
    public function collection()
    {
        $data = [];
        $answers = ['1' => '1.Ya', '0' => '2.Tidak', null => ''];
        $this->worksheets->each(function ($worksheet) use (&$data, $answers) {
            $worksheet->monitorings->each(function ($monitoring) use ($worksheet, &$data, $answers) {
                $riskCategory = '';
                if ($monitoring->incident?->risk_category_t2) {
                    $riskCategory .= $monitoring->incident->risk_category_t2->name;
                }

                if ($monitoring->incident?->risk_category_t3) {
                    $riskCategory .= ' & ' . $monitoring->incident->risk_category_t3->name;
                }

                $data[] = [
                    'Data Item' => $worksheet->worksheet_number,
                    'Nama Kejadian' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->incident_body ?? ''))),
                    'Identifikasi Kejadian ' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->incident_identification ?? ''))),
                    'Kategori Kejadian' => $monitoring->incident?->incident_category?->name ?? '',
                    'Sumber Penyebab Kejadian' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->incident_source ?? ''))),
                    'Penyebab Kejadian' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->incident_cause ?? ''))),
                    'Penanganan saat Kejadian' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->incident_handling ?? ''))),
                    'Deskripsi Kejadian - Risk Event' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->incident_description ?? ''))),
                    'Kategori Risiko Perusahaan' => $riskCategory,
                    'Penjelasan Kerugian' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->loss_description ?? ''))),
                    'Nilai Kerugian' => $monitoring->incident?->loss_value ?? '',
                    'Kejadian Berulang' => $answers[$monitoring->incident?->incident_repetitive ?? null],
                    'Frekuensi Kejadian' => $monitoring->incident?->incident_frequency?->name ?? '',
                    'Mitigasi yang Direncanakan' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->mitigation_plan ?? ''))),
                    'Realisasi Mitigasi' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->actualization_plan ?? ''))),
                    'Perbaikan Mendatang' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->follow_up_plan ?? ''))),
                    'Pihak terkait' => str_replace('\n', '\r\n', Html2Text::convert(html_entity_decode($monitoring->incident?->related_party ?? ''))),
                    'Status Asuransi' => $answers[$monitoring->incident?->insurance_status ?? null],
                    'Nilai Premi' => $monitoring->incident?->insurance_premi ? money_format($monitoring->incident->insurance_premi) : '',
                    'Nilai Klaim' => $monitoring->incident?->insurance_claim ? money_format($monitoring->incident->insurance_claim) : '',
                ];
            });
        });

        $this->count = count($data);
        return collect($data);
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function styles(Worksheet $sheet)
    {
        $this->lastColumn = $this->getLastColumn(count($this->headers));

        // Style for headers
        $sheet->getStyle("A1:{$this->lastColumn}1")->applyFromArray([
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

        $columnWidths = [
            'A' => 20,
            'B' => 36,
            'C' => 42,
            'D' => 36,
            'E' => 36,
            'F' => 36,
            'G' => 42,
            'H' => 42,
            'I' => 36,
            'J' => 36,
            'K' => 36,
            'L' => 24,
            'M' => 24,
            'N' => 54,
            'O' => 54,
            'P' => 54,
            'Q' => 42,
            'R' => 24,
            'S' => 36,
            'T' => 36,
        ];

        foreach (range('A', $this->lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setWidth($columnWidths[$column] ?? 18);
        }

        // Merge cells with same values for specific columns
        excel_merge_same_values(
            $sheet,
            [
                'A',
            ], // Columns to merge - adjust as needed
            2, // Start from row 3 (after headers)
            $this->count + 1
        );

        $sheet->getStyle("A1:{$this->lastColumn}" . ($this->count + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle('A2:A' . ($this->count + 1))->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '00B050']
            ],
        ]);

        $sheet->getStyle("A1:{$this->lastColumn}1")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A2:{$this->lastColumn}" . $this->count + 1)
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
        return 'Loss Event Database';
    }
}
