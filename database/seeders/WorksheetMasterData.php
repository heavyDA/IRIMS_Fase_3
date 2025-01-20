<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Master\KBUMNTarget;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\KRIThreshold;
use App\Models\Master\KRIUnit;
use App\Models\Master\BUMNScale;
use App\Models\Master\Company;
use App\Models\Master\ExistingControlType;
use App\Models\Master\Heatmap;
use App\Models\Master\ControlEffectivenessAssessment;
use App\Models\Master\IncidentCategory;
use App\Models\Master\IncidentFrequency;
use App\Models\Master\RiskMetric;
use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentType;
use App\Models\Master\RKAPProgramType;

class WorksheetMasterData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $targets = [
            ['name' => 'Nilai ekonomi dan sosial'],
            ['name' => 'Inovasi bisnis model'],
            ['name' => 'Kepemimpinan teknologi'],
            ['name' => 'Peningkatan investasi'],
            ['name' => 'Pengembangan talenta'],
        ];

        if (KBUMNTarget::count() == 0) {
            KBUMNTarget::insert($targets);
        }

        $categories = [
            ['type' => 'T2', 'name' => 'Risiko Investasi'],
            ['type' => 'T2', 'name' => 'Risiko Pasar'],
            ['type' => 'T2', 'name' => 'Risiko Likuiditas'],
            ['type' => 'T2', 'name' => 'Risiko Operasional'],
            ['type' => 'T2', 'name' => 'Risiko Hukum'],
            ['type' => 'T2', 'name' => 'Risiko Reputasi'],
            ['type' => 'T2', 'name' => 'Risiko Strategis'],
            ['type' => 'T2', 'name' => 'Risiko Kepatuhan'],
            ['type' => 'T2', 'name' => 'Risiko Transaksi Antar Entitas Grup'],
            ['type' => 'T2', 'name' => 'Risiko Asuransi'],

            ['type' => 'T3', 'name' => 'Peristiwa Risiko Dividen'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Subsidi & Kompensasi'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Konsentrasi Portofolio'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Struktur Korporasi'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko M & A, JV, Restru'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Pasar & Makroekonomi'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Keuangan'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Kebijakan SDM'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Proyek'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Teknologi Informasi & Keamanan Siber'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Sosial & Lingkungan'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Operasional'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Hukum, Reputasi & Kepatuhan'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Hukum, Reputasi & Kepatuhan'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko PMN'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Kebijakan Sektoral'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Formulasi Strategis'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Hukum, Reputasi & Kepatuhan'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Struktur Korporasi'],
            ['type' => 'T3', 'name' => 'Peristiwa Risiko Keuangan'],
        ];
        if (KBUMNRiskCategory::count() == 0) {
            KBUMNRiskCategory::insert($categories);
        }

        $kri_units = [
            ['name' => '%'],
            ['name' => 'Rp'],
            ['name' => 'Rp triliun'],
            ['name' => 'Rp milyar'],
            ['name' => 'skala likert 1-5'],
            ['name' => 'unit'],
            ['name' => 'score'],
            ['name' => 'bulan'],
            ['name' => 'hari'],
            ['name' => 'Jumlah'],
            ['name' => 'Pax'],
            ['name' => 'Jam'],
            ['name' => 'Menit'],
        ];

        if (KRIUnit::count() == 0) {
            KRIUnit::insert($kri_units);
        }

        $kri_thresholds = [
            ['name' => 'Aman', 'color' => '', 'color_nice' => 'success'],
            ['name' => 'Hati-hati', 'color' => '', 'color_nice' => 'warning'],
            ['name' => 'Bahaya', 'color' => '', 'color_nice' => 'danger'],
        ];

        if (KRIThreshold::count() == 0) {
            KRIThreshold::insert($kri_thresholds);
        }

        $ext_control_types = [
            ['name' => 'Kontrol operasi - level entitas/kantor pusat',],
            ['name' => 'Kontrol operasi - level operasi',],
            ['name' => 'Kontrol kepatuhan (compliance) - level entitas/kantor pusat',],
            ['name' => 'Kontrol kepatuhan (compliance) - level operasi',],
            ['name' => 'Kontrol pelaporan - level entitas/kantor pusat',],
            ['name' => 'Kontrol pelaporan - level operasi',],
        ];

        if (ExistingControlType::count() == 0) {
            ExistingControlType::insert($ext_control_types);
        }

        $control_effect_assessments = [
            ['name' => 'Cukup dan Efektif',],
            ['name' => 'Cukup dan Efektif Sebagian',],
            ['name' => 'Cukup dan Tidak Efektif',],
            ['name' => 'Tidak Cukup dan Efektif Sebagian',],
            ['name' => 'Tidak Cukup dan Tidak Efektif',],
        ];

        if (ControlEffectivenessAssessment::count() == 0) {
            ControlEffectivenessAssessment::insert($control_effect_assessments);
        }

        $bumn_scales = [
            [
                'impact_category' => "kuantitatif",
                "scale" => 1,
                'criteria' => "Sangat Rendah",
                "min" => 0,
                "max" => 20,
                'description' => "kemungkinan sangat rendah yang dapat mengakibatkan kerusakan\/ kerugian\/ penurunan kurang dari 20% dari nilai Batasan Risiko\n\n"
            ],
            [
                'impact_category' => "kuantitatif",
                "scale" => 2,
                'criteria' => "Rendah",
                "min" => 21,
                "max" => 40,
                'description' => "kemungkinan sangat rendah yang dapat mengakibatkanrendah yang dapat mengakibatkan kerusakan\/kerugian\/penurunan 20%-40% dari nilai Batasan Risiko\n\n"
            ],
            [
                'impact_category' => "kuantitatif",
                "scale" => 3,
                'criteria' => "Moderat",
                "min" => 41,
                "max" => 60,
                'description' => "kemungkinan sangat rendah yang dapat mengakibatkan kritis yang dapat mengakibatkan kerusakan\/kerugian\/penurunan 40%-60% dari nilai Batasan Risiko\n\n"
            ],
            [
                'impact_category' => "kuantitatif",
                "scale" => 4,
                'criteria' => "Tinggi",
                "min" => 61,
                "max" => 80,
                'description' => "kemungkinan sangat rendah yang dapat mengakibatkandisruptif yang dapat mengakibatkan kerusakan\/ kerugian\/ penurunan 60%-80% dari nilai Batasan Risiko\n\n"
            ],
            [
                'impact_category' => "kuantitatif",
                "scale" => 5,
                'criteria' => "Sangat Tinggi",
                "min" => 81,
                "max" => 100,
                'description' => "kemungkinan sangat rendah yang dapat mengakibatkankatastrofe yang dapat mengakibatkan kerusakan\/ kerugian\/ penurunan > 80% dari nilai Batasan Risiko\n\n"
            ],
            [
                'impact_category' => "kualitatif",
                "scale" => 1,
                'criteria' => "Sangat Rendah",
                "min" => 0,
                "max" => 19,
                'description' => ""
            ],
            [
                'impact_category' => "kualitatif",
                "scale" => 2,
                'criteria' => "Rendah",
                "min" => 20,
                "max" => 40,
                'description' => ""
            ],
            [
                'impact_category' => "kualitatif",
                "scale" => 3,
                'criteria' => "Moderat",
                "min" => 41,
                "max" => 60,
                'description' => ""
            ],
            [
                'impact_category' => "kualitatif",
                "scale" => 4,
                'criteria' => "Tinggi",
                "min" => 61,
                "max" => 80,
                'description' => ""
            ],
            [
                'impact_category' => "kualitatif",
                "scale" => 5,
                'criteria' => "Sangat Tinggi",
                "min" => 81,
                "max" => 100,
                'description' => ""
            ]
        ];

        if (BUMNScale::count() == 0) {
            BUMNScale::insert($bumn_scales);
        }

        $heatmaps = [
            [
                "impact_scale" => 1,
                "impact_probability" => 1,
                "risk_scale" => 1,
                'risk_level' => "Low",
                'color' => "#00B050"
            ],
            [
                "impact_scale" => 1,
                "impact_probability" => 2,
                "risk_scale" => 2,
                'risk_level' => "Low",
                'color' => "#00B050"
            ],
            [
                "impact_scale" => 1,
                "impact_probability" => 3,
                "risk_scale" => 3,
                'risk_level' => "Low",
                'color' => "#00B050"
            ],
            [
                "impact_scale" => 1,
                "impact_probability" => 4,
                "risk_scale" => 4,
                'risk_level' => "Low",
                'color' => "#00B050"
            ],
            [
                "impact_scale" => 1,
                "impact_probability" => 5,
                "risk_scale" => 7,
                'risk_level' => "Low to Moderate",
                'color' => "#92D050"
            ],
            [
                "impact_scale" => 2,
                "impact_probability" => 1,
                "risk_scale" => 5,
                'risk_level' => "Low",
                'color' => "#00B050"
            ],
            [
                "impact_scale" => 2,
                "impact_probability" => 2,
                "risk_scale" => 6,
                'risk_level' => "Low to Moderate",
                'color' => "#92D050"
            ],
            [
                "impact_scale" => 2,
                "impact_probability" => 3,
                "risk_scale" => 8,
                'risk_level' => "Low to Moderate",
                'color' => "#92D050"
            ],
            [
                "impact_scale" => 2,
                "impact_probability" => 4,
                "risk_scale" => 9,
                'risk_level' => "Low to Moderate",
                'color' => "#92D050"
            ],
            [
                "impact_scale" => 2,
                "impact_probability" => 5,
                "risk_scale" => 12,
                'risk_level' => "Moderate",
                'color' => "#FFFF00"
            ],
            [
                "impact_scale" => 3,
                "impact_probability" => 1,
                "risk_scale" => 10,
                'risk_level' => "Low to Moderate",
                'color' => "#92D050"
            ],
            [
                "impact_scale" => 3,
                "impact_probability" => 2,
                "risk_scale" => 11,
                'risk_level' => "Low to Moderate",
                'color' => "#92D050"
            ],
            [
                "impact_scale" => 3,
                "impact_probability" => 3,
                "risk_scale" => 13,
                'risk_level' => "Moderate",
                'color' => "#FFFF00"
            ],
            [
                "impact_scale" => 3,
                "impact_probability" => 4,
                "risk_scale" => 14,
                'risk_level' => "Moderate",
                'color' => "#FFFF00"
            ],
            [
                "impact_scale" => 3,
                "impact_probability" => 5,
                "risk_scale" => 17,
                'risk_level' => "Moderate to High",
                'color' => "#FFC000"
            ],
            [
                "impact_scale" => 4,
                "impact_probability" => 1,
                "risk_scale" => 15,
                'risk_level' => "Moderate",
                'color' => "#FFFF00"
            ],
            [
                "impact_scale" => 4,
                "impact_probability" => 2,
                "risk_scale" => 16,
                'risk_level' => "Moderate to High",
                'color' => "#FFC000"
            ],
            [
                "impact_scale" => 4,
                "impact_probability" => 3,
                "risk_scale" => 18,
                'risk_level' => "Moderate to High",
                'color' => "#FFC000"
            ],
            [
                "impact_scale" => 4,
                "impact_probability" => 4,
                "risk_scale" => 19,
                'risk_level' => "Moderate to High",
                'color' => "#FFC000"
            ],
            [
                "impact_scale" => 4,
                "impact_probability" => 5,
                "risk_scale" => 22,
                'risk_level' => "High",
                'color' => "#FE0000"
            ],
            [
                "impact_scale" => 5,
                "impact_probability" => 1,
                "risk_scale" => 20,
                'risk_level' => "High",
                'color' => "#FE0000"
            ],
            [
                "impact_scale" => 5,
                "impact_probability" => 2,
                "risk_scale" => 21,
                'risk_level' => "High",
                'color' => "#FE0000"
            ],
            [
                "impact_scale" => 5,
                "impact_probability" => 3,
                "risk_scale" => 23,
                'risk_level' => "High",
                'color' => "#FE0000"
            ],
            [
                "impact_scale" => 5,
                "impact_probability" => 4,
                "risk_scale" => 24,
                'risk_level' => "High",
                'color' => "#FE0000"
            ],
            [
                "impact_scale" => 5,
                "impact_probability" => 5,
                "risk_scale" => 25,
                'risk_level' => "High",
                'color' => "#FE0000"
            ]
        ];

        if (Heatmap::count() == 0) {
            Heatmap::insert($heatmaps);
        }

        $rkap_program_types = [
            [
                "parent_id" => null,
                'number' => "A",
                'name' => "BEBAN PEGAWAI",
            ],
            [
                "parent_id" => null,
                'number' => "B",
                'name' => "BEBAN OPERASIONAL BANDARA",
            ],
            [
                "parent_id" => null,
                'number' => "C",
                'name' => "BEBAN ADMINISTRASI DAN UMUM",
            ],
            [
                "parent_id" => null,
                'number' => "D",
                'name' => "BEBAN PEMASARAN",
            ],
            [
                "parent_id" => null,
                'number' => "E",
                'name' => "Lain-lain",
            ],
            [
                "parent_id" => 1,
                'number' => "1",
                'name' => "Beban Gaji dan Upah",
            ],
            [
                "parent_id" => 1,
                'number' => "2",
                'name' => "Beban Honorarium",
            ],
            [
                "parent_id" => 1,
                'number' => "3",
                'name' => "Tunjangan-Tunjangan",
            ],
            [
                "parent_id" => 1,
                'number' => "4",
                'name' => "Beban Lembur",
            ],
            [
                "parent_id" => 1,
                'number' => "5",
                'name' => "Beban Bonus",
            ],
            [
                "parent_id" => 1,
                'number' => "6",
                'name' => "Beban Pakaian Dinas",
            ],
            [
                "parent_id" => 1,
                'number' => "7",
                'name' => "Beban Pengobatan",
            ],
            [
                "parent_id" => 1,
                'number' => "8",
                'name' => "Beban Sumbangan",
            ],
            [
                "parent_id" => 2,
                'number' => "1",
                'name' => "Beban Outsourcing",
            ],
            [
                "parent_id" => 2,
                'number' => "2",
                'name' => "Beban Perlengkapan dan Bahan",
            ],
            [
                "parent_id" => 2,
                'number' => "3",
                'name' => "Beban Pemeliharaan dan Perbaikan",
            ],
            [
                "parent_id" => 2,
                'number' => "4",
                'name' => "Beban Komunikasi dan Utilitas",
            ],
            [
                "parent_id" => 2,
                'number' => "5",
                'name' => "Beban Amortisasi Tak Berwujud",
            ],
            [
                "parent_id" => 2,
                'number' => "6",
                'name' => "Beban Penurunan Nilai Aset ",
            ],
            [
                "parent_id" => 2,
                'number' => "7",
                'name' => "Beban Penyusutan",
            ],
            [
                "parent_id" => 2,
                'number' => "8",
                'name' => "Beban Operasional Bandara Lainnya",
            ],
            [
                "parent_id" => 3,
                'number' => "1",
                'name' => "Beban Dewan Komisaris dan Direksi",
            ],
            [
                "parent_id" => 3,
                'number' => "2",
                'name' => "Beban Pajak Lainnya",
            ],
            [
                "parent_id" => 3,
                'number' => "3",
                'name' => "Beban Perjalanan Dinas",
            ],
            [
                "parent_id" => 3,
                'number' => "4",
                'name' => "Beban Asuransi",
            ],
            [
                "parent_id" => 3,
                'number' => "5",
                'name' => "Beban Pengembangan SDM",
            ],
            [
                "parent_id" => 3,
                'number' => "6",
                'name' => "Beban Imbalan Paska Kerja",
            ],
            [
                "parent_id" => 3,
                'number' => "7",
                'name' => "Beban Umum dan Administrasi Lainnya",
            ],
            [
                "parent_id" => 3,
                'number' => "8",
                'name' => "Beban Collection",
            ],
            [
                "parent_id" => 3,
                'number' => "9",
                'name' => "Beban Aset Dibiayakan",
            ],
            [
                "parent_id" => 4,
                'number' => "1",
                'name' => "Beban Pemasaran",
            ],
            [
                "parent_id" => 5,
                'number' => "1",
                'name' => "Lain-lain",
            ]
        ];

        if (RKAPProgramType::count() == 0) {
            RKAPProgramType::insert($rkap_program_types);
        }

        $risk_treatment_plan_types = [
            [
                'name' => "Peningkatan Kecukupan Desain Kontrol"
            ],
            [
                'name' => "Peningkatan Efektivitas Pelaksanaan Kontrol"
            ],
            [
                'name' => "Perbaikan Melalui Breakthrough Project"
            ],
            [
                'name' => "Peningkatan Kecukupan Desain Kontrol dan Peningkatan Efektivitas Pelaksanaan Kontrol"
            ],
            [
                'name' => "Peningkatan Kecukupan Desain Kontrol dan Perbaikan Melalui Breakthrough Project"
            ],
            [
                'name' => "Peningkatan Efektivitas Pelaksanaan Kontrol dan dan Perbaikan Melalui Breakthrough Project"
            ],
            [
                'name' => "Peningkatan Kecukupan Desain Kontrol, Peningkatan Efektivitas Pelaksanaan Kontrol, dan Pebaikan Melalui Breakthrough Project"
            ],
            [
                'name' => "Lainnya"
            ]
        ];

        if (RiskTreatmentType::count() == 0) {
            RiskTreatmentType::insert($risk_treatment_plan_types);
        }

        $risk_treatment_options = [
            [
                'name' => "Transfer sharing "
            ],
            [
                'name' => "Reduce mitigate"
            ],
            [
                'name' => "Accept monitor"
            ],
            [
                'name' => "Avoid hindari"
            ]
        ];

        if (RiskTreatmentOption::count() == 0) {
            RiskTreatmentOption::insert($risk_treatment_options);
        }

        $incidentCategories = [
            ['name' => 'Perampokan bersenjata'],
            ['name' => 'Kecelakaan'],
            ['name' => 'Tabrakan'],
            ['name' => 'Kejahatan siber'],
            ['name' => 'Gempa bumi'],
            ['name' => 'Pengaturan/penanganan yang salah'],
            ['name' => 'Kecurangan (penipuan)'],
            ['name' => 'Kebakaran'],
            ['name' => 'Banjir'],
            ['name' => 'Penyakit'],
            ['name' => 'Petir'],
            ['name' => 'Kelalaian'],
            ['name' => 'Kerusuhan/perang'],
            ['name' => 'Korsleting/arus pendek'],
            ['name' => 'Mogok Kerja'],
            ['name' => 'Pencurian'],
            ['name' => 'Angin topan/badai'],
            ['name' => 'Lainnya'],
        ];

        if (IncidentCategory::count() == 0) {
            IncidentCategory::insert($incidentCategories);
        }

        $riskMetrics = [
            [
                'organization_code' => 'ap.50',
                'personnel_area_code' => 'KST',
                'personnel_area_name' => 'Kantor Pusat',
                'capacity' => '10000000000',
                'appetite' => '7500000000',
                'tolerancy' => '12500000000',
                'limit' => '10000000000',
            ],
            [
                'organization_code' => 'ap.51',
                'personnel_area_code' => 'CGK',
                'personnel_area_name' => 'BANDARA SOEKARNNO-HATTA',
                'capacity' => '3000000000',
                'appetite' => '2000000000',
                'tolerancy' => '3250000000',
                'limit' => '3000000000',
            ],
            [
                'organization_code' => 'ap.52',
                'personnel_area_code' => 'DPS',
                'personnel_area_name' => 'BANDARA I GUSTI NGURAH RAI',
                'capacity' => '3000000000',
                'appetite' => '2000000000',
                'tolerancy' => '3250000000',
                'limit' => '3000000000',
            ],
            [
                'organization_code' => 'ap.53',
                'personnel_area_code' => 'KNO',
                'personnel_area_name' => 'Bandara Kualanamu',
                'capacity' => '3000000000',
                'appetite' => '2000000000',
                'tolerancy' => '3250000000',
                'limit' => '3000000000',
            ],
            [
                'organization_code' => 'ap.54',
                'personnel_area_code' => 'YIA',
                'personnel_area_name' => 'Bandara Internasional Yogyakarta',
                'capacity' => '3000000000',
                'appetite' => '2000000000',
                'tolerancy' => '3250000000',
                'limit' => '3000000000',
            ],
            [
                'organization_code' => 'ap.55',
                'personnel_area_code' => 'BPN',
                'personnel_area_name' => 'Bandara Internasional Sepinggan',
                'capacity' => '3000000000',
                'appetite' => '2000000000',
                'tolerancy' => '3250000000',
                'limit' => '3000000000',
            ],
            [
                'organization_code' => 'ap.56',
                'personnel_area_code' => 'UPG',
                'personnel_area_name' => 'Bandara Sultan Hasanuddin',
                'capacity' => '3000000000',
                'appetite' => '2000000000',
                'tolerancy' => '3250000000',
                'limit' => '3000000000',
            ],
        ];
        if (RiskMetric::count() == 0) {
            RiskMetric::insert($riskMetrics);
        }

        $frequencies = [
            ['name' => '2 kali dalam 1 tahun'],
            ['name' => '3 kali dalam 1 tahun'],
            ['name' => '4 kali dalam 1 tahun'],
            ['name' => '5 kali dalam 1 tahun'],
            ['name' => '>5 kali dalam 1 tahun'],
        ];

        if (IncidentFrequency::count() == 0) {
            IncidentFrequency::insert($frequencies);
        }
    }
}
