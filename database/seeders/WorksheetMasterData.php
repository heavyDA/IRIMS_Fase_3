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
use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentPlanType;
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
            ['type' => 'T2', 'name' => 'Risiko Fiskal',],
            ['type' => 'T2', 'name' => 'Risiko Kebijakan',],
            ['type' => 'T2', 'name' => 'Risiko Komposisi',],
            ['type' => 'T2', 'name' => 'Risiko Struktur',],
            ['type' => 'T2', 'name' => 'Risiko Restrukturisasi & Reorganisasi',],
            ['type' => 'T2', 'name' => 'Risiko Industri Umum',],
            ['type' => 'T2', 'name' => 'Risiko Industri Perbanka',],
            ['type' => 'T2', 'name' => 'Risiko Industri Asuransi',],
            ['type' => 'T3', 'name' => 'Dividen',],
            ['type' => 'T3', 'name' => 'PMN',],
            ['type' => 'T3', 'name' => 'Subsidi & Kompensasi',],
            ['type' => 'T3', 'name' => 'SDM',],
            ['type' => 'T3', 'name' => 'Sektoral',],
            ['type' => 'T3', 'name' => 'Konsentrasi Portofolio',],
            ['type' => 'T3', 'name' => 'Struktur Korporasi',],
            ['type' => 'T3', 'name' => 'Penggabungan, Pengambilalihan, Peleburan, Pemisahan, Pembubaran, Likuidasi, Kemitraan, dan Restrukturisasi',],
            ['type' => 'T3', 'name' => 'Formulasi Strategis',],
            ['type' => 'T3', 'name' => 'Pasar & Makroekonomi',],
            ['type' => 'T3', 'name' => 'Keuangan',],
            ['type' => 'T3', 'name' => 'Reputasi & Kepatuhan',],
            ['type' => 'T3', 'name' => 'Proyek',],
            ['type' => 'T3', 'name' => 'Teknologi & Keamanan Siber',],
            ['type' => 'T3', 'name' => 'Sosial & Lingkungan',],
            ['type' => 'T3', 'name' => 'Operasional',],
            ['type' => 'T3', 'name' => 'Kredit',],
            ['type' => 'T3', 'name' => 'Likuiditas',],
            ['type' => 'T3', 'name' => 'Investasi',],
            ['type' => 'T3', 'name' => 'Aktuarial',],
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

        if (RiskTreatmentPlanType::count() == 0) {
            RiskTreatmentPlanType::insert($risk_treatment_plan_types);
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

        $companies = [
            [
                'work_unit_code' => "50000000",
                'work_unit_name' => "PT. ANGKASA PURA II (Persero)",
                'work_sub_unit_code' => "60082009",
                'work_sub_unit_name' => "BANDARA JENDERAL BESAR SOEDIRMAN",
                'organization_code' => "50000000",
                'organization_name' => "PT. ANGKASA PURA II (Persero)",
                'personal_area_code' => "PWL",
                'personal_area_name' => "Bandar Udara Jenderal Besar Soedirman"
            ],
            [
                'work_unit_code' => "50000010",
                'work_unit_name' => "BANDARA HALIM PERDANAKUSUMA",
                'work_sub_unit_code' => "60085540",
                'work_sub_unit_name' => "SAFETY, RISK, & QUALITY CONTROL",
                'organization_code' => "50000010",
                'organization_name' => "BANDARA HALIM PERDANAKUSUMA",
                'personal_area_code' => "",
                "personal_area_name" => null
            ],
            [
                'work_unit_code' => "50000012",
                'work_unit_name' => "BANDARA SULTAN SYARIF KASIM II",
                'work_sub_unit_code' => "60055865",
                'work_sub_unit_name' => "SAFETY & RISK MANAGEMENT",
                'organization_code' => "50000012",
                'organization_name' => "BANDARA SULTAN SYARIF KASIM II",
                'personal_area_code' => "",
                "personal_area_name" => null
            ],
            [
                'work_unit_code' => "50000015",
                'work_unit_name' => "BANDARA INTERNATIONAL MINANGKABAU",
                'work_sub_unit_code' => "60055768",
                'work_sub_unit_name' => "SAFETY & RISK MANAGEMENT",
                'organization_code' => "50000015",
                'organization_name' => "BANDARA INTERNATIONAL MINANGKABAU",
                'personal_area_code' => "PDG",
                'personal_area_name' => "Bandara Minangkabau"
            ],
            [
                'work_unit_code' => "50000016",
                'work_unit_name' => "BANDARA HUSEIN SASTRANEGARA",
                'work_sub_unit_code' => "60056191",
                'work_sub_unit_name' => "SAFETY & RISK MANAGEMENT",
                'organization_code' => "50000016",
                'organization_name' => "BANDARA HUSEIN SASTRANEGARA",
                'personal_area_code' => "",
                "personal_area_name" => null
            ],
            [
                'work_unit_code' => "50000017",
                'work_unit_name' => "BANDARA SULTAN ISKANDARMU",
                'work_sub_unit_code' => "60055857",
                'work_sub_unit_name' => "SAFETY, RISK & QUALITY CONTROL",
                'organization_code' => "50000017",
                'organization_name' => "BANDARA SULTAN ISKANDARMU",
                'personal_area_code' => "BTJ",
                'personal_area_name' => "Bandara Sultan Iskandar Muda"
            ],
            [
                'work_unit_code' => "50000018",
                'work_unit_name' => "BANDARA RAJA HAJI FISABILILLAH",
                'work_sub_unit_code' => "50000018",
                'work_sub_unit_name' => "BANDARA RAJA HAJI FISABILILLAH",
                'organization_code' => "50000018",
                'organization_name' => "BANDARA RAJA HAJI FISABILILLAH",
                'personal_area_code' => "TNJ",
                'personal_area_name' => "Bandara Raja Haji Fisabilillah"
            ],
            [
                'work_unit_code' => "60031859",
                'work_unit_name' => "BANDARA SILANGIT",
                'work_sub_unit_code' => "60055798",
                'work_sub_unit_name' => "SAFETY, RISK, & QUALITY CONTROL",
                'organization_code' => "60031859",
                'organization_name' => "BANDARA SILANGIT",
                'personal_area_code' => "DTB",
                'personal_area_name' => "Bandara Silangit"
            ],
            [
                'work_unit_code' => "60055263",
                'work_unit_name' => "AIRSIDE OPERATION",
                'work_sub_unit_code' => "60076170",
                'work_sub_unit_name' => "APRON MANAGEMENT SERVICE - T2",
                'organization_code' => "60055263",
                'organization_name' => "AIRSIDE OPERATION",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055493",
                'work_unit_name' => "AIRPORT OPERATION & SERVICE",
                'work_sub_unit_code' => "60055495",
                'work_sub_unit_name' => "AIRSIDE OPERATION",
                'organization_code' => "60055493",
                'organization_name' => "AIRPORT OPERATION & SERVICE",
                'personal_area_code' => "DJB",
                'personal_area_name' => "Bandara Sultan Thaha"
            ],
            [
                'work_unit_code' => "60055633",
                'work_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'work_sub_unit_code' => "60055633",
                'work_sub_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'organization_code' => "60055633",
                'organization_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'personal_area_code' => "DJB",
                'personal_area_name' => "Bandara Sultan Thaha"
            ],
            [
                'work_unit_code' => "60055635",
                'work_unit_name' => "INFRASTRUCTURE",
                'work_sub_unit_code' => "60055635",
                'work_sub_unit_name' => "INFRASTRUCTURE",
                'organization_code' => "60055635",
                'organization_name' => "INFRASTRUCTURE",
                'personal_area_code' => "DJB",
                'personal_area_name' => "Bandara Sultan Thaha"
            ],
            [
                'work_unit_code' => "60055637",
                'work_unit_name' => "FINANCE & HUMAN RESOURCES",
                'work_sub_unit_code' => "60055760",
                'work_sub_unit_name' => "COMMUNITY DEVELOPMENT",
                'organization_code' => "60055637",
                'organization_name' => "FINANCE & HUMAN RESOURCES",
                'personal_area_code' => "DJB",
                'personal_area_name' => "Bandara Sultan Thaha"
            ],
            [
                'work_unit_code' => "60055673",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60055750",
                'work_sub_unit_name' => "TERMINAL & GENERAL BUILDING",
                'organization_code' => "60055673",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "PDG",
                'personal_area_name' => "Bandara Minangkabau"
            ],
            [
                'work_unit_code' => "60055700",
                'work_unit_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'work_sub_unit_code' => "60055727",
                'work_sub_unit_name' => "AIRCRAFT RESCUE & FIRE FIGHTING",
                'organization_code' => "60055700",
                'organization_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055725",
                'work_unit_name' => "ELECTRONIC FACILITY & IT",
                'work_sub_unit_code' => "60055725",
                'work_sub_unit_name' => "ELECTRONIC FACILITY & IT",
                'organization_code' => "60055725",
                'organization_name' => "ELECTRONIC FACILITY & IT",
                'personal_area_code' => "PDG",
                'personal_area_name' => "Bandara Minangkabau"
            ],
            [
                'work_unit_code' => "60055729",
                'work_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'work_sub_unit_code' => "60055729",
                'work_sub_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'organization_code' => "60055729",
                'organization_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'personal_area_code' => "PDG",
                'personal_area_name' => "Bandara Minangkabau"
            ],
            [
                'work_unit_code' => "60055736",
                'work_unit_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILITY",
                'work_sub_unit_code' => "60055736",
                'work_sub_unit_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILITY",
                'organization_code' => "60055736",
                'organization_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILITY",
                'personal_area_code' => "PDG",
                'personal_area_name' => "Bandara Minangkabau"
            ],
            [
                'work_unit_code' => "60055740",
                'work_unit_name' => "AIRPORT SECURITY",
                'work_sub_unit_code' => "60076345",
                'work_sub_unit_name' => "CCTV",
                'organization_code' => "60055740",
                'organization_name' => "AIRPORT SECURITY",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055863",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60055875",
                'work_sub_unit_name' => "TERMINAL & GENERAL BUILDING",
                'organization_code' => "60055863",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "PKU",
                'personal_area_name' => "Bandara Sultan Syarif Kasim II"
            ],
            [
                'work_unit_code' => "60055873",
                'work_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'work_sub_unit_code' => "60055873",
                'work_sub_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'organization_code' => "60055873",
                'organization_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'personal_area_code' => "PKU",
                'personal_area_name' => "Bandara Sultan Syarif Kasim II"
            ],
            [
                'work_unit_code' => "60055877",
                'work_unit_name' => "FINANCIAL CONTROL",
                'work_sub_unit_code' => "60055877",
                'work_sub_unit_name' => "FINANCIAL CONTROL",
                'organization_code' => "60055877",
                'organization_name' => "FINANCIAL CONTROL",
                'personal_area_code' => "PKU",
                'personal_area_name' => "Bandara Sultan Syarif Kasim II"
            ],
            [
                'work_unit_code' => "60055931",
                'work_unit_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'work_sub_unit_code' => "60055931",
                'work_sub_unit_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'organization_code' => "60055931",
                'organization_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'personal_area_code' => "PLM",
                'personal_area_name' => "Bandara Sultan Mahmud Badaruddin II"
            ],
            [
                'work_unit_code' => "60055933",
                'work_unit_name' => "AIRPORT SECURITY",
                'work_sub_unit_code' => "60055933",
                'work_sub_unit_name' => "AIRPORT SECURITY",
                'organization_code' => "60055933",
                'organization_name' => "AIRPORT SECURITY",
                'personal_area_code' => "PLM",
                'personal_area_name' => "Bandara Sultan Mahmud Badaruddin II"
            ],
            [
                'work_unit_code' => "60055937",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60055942",
                'work_sub_unit_name' => "TERMINAL & GENERAL BUILDING",
                'organization_code' => "60055937",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "PLM",
                'personal_area_name' => "Bandara Sultan Mahmud Badaruddin II"
            ],
            [
                'work_unit_code' => "60055941",
                'work_unit_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILITY",
                'work_sub_unit_code' => "60055941",
                'work_sub_unit_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILITY",
                'organization_code' => "60055941",
                'organization_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILITY",
                'personal_area_code' => "PLM",
                'personal_area_name' => "Bandara Sultan Mahmud Badaruddin II"
            ],
            [
                'work_unit_code' => "60055965",
                'work_unit_name' => "TERMINAL SERVICE - T1",
                'work_sub_unit_code' => "60056050",
                'work_sub_unit_name' => "DIGITAL SERVICE - T1",
                'organization_code' => "60055965",
                'organization_name' => "TERMINAL SERVICE - T1",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055967",
                'work_unit_name' => "TERMINAL SERVICE - T2",
                'work_sub_unit_code' => "60056062",
                'work_sub_unit_name' => "PASSENGER SERVICE - T2",
                'organization_code' => "60055967",
                'organization_name' => "TERMINAL SERVICE - T2",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055968",
                'work_unit_name' => "TERMINAL FACILITY - T2",
                'work_sub_unit_code' => "60055968",
                'work_sub_unit_name' => "TERMINAL FACILITY - T2",
                'organization_code' => "60055968",
                'organization_name' => "TERMINAL FACILITY - T2",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055969",
                'work_unit_name' => "TERMINAL SERVICE - T3",
                'work_sub_unit_code' => "60056324",
                'work_sub_unit_name' => "PASSENGER SERVICE - T3",
                'organization_code' => "60055969",
                'organization_name' => "TERMINAL SERVICE - T3",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055971",
                'work_unit_name' => "LANDSIDE & CARGO SERVICE",
                'work_sub_unit_code' => "60056314",
                'work_sub_unit_name' => "LANDSIDE SERVICE",
                'organization_code' => "60055971",
                'organization_name' => "LANDSIDE & CARGO SERVICE",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60055972",
                'work_unit_name' => "LANDSIDE FACILITY",
                'work_sub_unit_code' => "60056319",
                'work_sub_unit_name' => "SAFETY & SECURITY FAC. NON TERMINAL",
                'organization_code' => "60055972",
                'organization_name' => "LANDSIDE FACILITY",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056052",
                'work_unit_name' => "SAFETY & SECURITY FACILITY - T1",
                'work_sub_unit_code' => "60056052",
                'work_sub_unit_name' => "SAFETY & SECURITY FACILITY - T1",
                'organization_code' => "60056052",
                'organization_name' => "SAFETY & SECURITY FACILITY - T1",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056053",
                'work_unit_name' => "GENERAL ELECTRONIC FACILITY - T1",
                'work_sub_unit_code' => "60056053",
                'work_sub_unit_name' => "GENERAL ELECTRONIC FACILITY - T1",
                'organization_code' => "60056053",
                'organization_name' => "GENERAL ELECTRONIC FACILITY - T1",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056054",
                'work_unit_name' => "ELECTRICAL FACILITY - T1",
                'work_sub_unit_code' => "60056054",
                'work_sub_unit_name' => "ELECTRICAL FACILITY - T1",
                'organization_code' => "60056054",
                'organization_name' => "ELECTRICAL FACILITY - T1",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056055",
                'work_unit_name' => "TERMINAL BUILDING - T2",
                'work_sub_unit_code' => "60056055",
                'work_sub_unit_name' => "TERMINAL BUILDING - T2",
                'organization_code' => "60056055",
                'organization_name' => "TERMINAL BUILDING - T2",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056056",
                'work_unit_name' => "SAFETY & SECURITY FACILITY - T1",
                'work_sub_unit_code' => "60056056",
                'work_sub_unit_name' => "SAFETY & SECURITY FACILITY - T2",
                'organization_code' => "60056056",
                'organization_name' => "SAFETY & SECURITY FACILITY - T1",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056057",
                'work_unit_name' => "GENERAL ELECTRONIC FACILITY - T2",
                'work_sub_unit_code' => "60056057",
                'work_sub_unit_name' => "GENERAL ELECTRONIC FACILITY - T2",
                'organization_code' => "60056057",
                'organization_name' => "GENERAL ELECTRONIC FACILITY - T2",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056058",
                'work_unit_name' => "ELECTRICAL FACILITY - T2",
                'work_sub_unit_code' => "60056058",
                'work_sub_unit_name' => "ELECTRICAL FACILITY - T2",
                'organization_code' => "60056058",
                'organization_name' => "ELECTRICAL FACILITY - T2",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056059",
                'work_unit_name' => "MECHANICAL FACILITY - T2",
                'work_sub_unit_code' => "60056059",
                'work_sub_unit_name' => "MECHANICAL FACILITY - T2",
                'organization_code' => "60056059",
                'organization_name' => "MECHANICAL FACILITY - T2",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056064",
                'work_unit_name' => "TERMINAL BUILDING - T3",
                'work_sub_unit_code' => "60056064",
                'work_sub_unit_name' => "TERMINAL BUILDING - T3",
                'organization_code' => "60056064",
                'organization_name' => "TERMINAL BUILDING - T3",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056065",
                'work_unit_name' => "SAFETY & SECURITY FACILITY - T3",
                'work_sub_unit_code' => "60056065",
                'work_sub_unit_name' => "SAFETY & SECURITY FACILITY - T3",
                'organization_code' => "60056065",
                'organization_name' => "SAFETY & SECURITY FACILITY - T3",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056066",
                'work_unit_name' => "GENERAL ELECTRONIC FACILITY - T3",
                'work_sub_unit_code' => "60056066",
                'work_sub_unit_name' => "GENERAL ELECTRONIC FACILITY - T3",
                'organization_code' => "60056066",
                'organization_name' => "GENERAL ELECTRONIC FACILITY - T3",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056067",
                'work_unit_name' => "ELECTRICAL FACILITY - T3",
                'work_sub_unit_code' => "60056067",
                'work_sub_unit_name' => "ELECTRICAL FACILITY - T3",
                'organization_code' => "60056067",
                'organization_name' => "ELECTRICAL FACILITY - T3",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056068",
                'work_unit_name' => "MECHANICAL FACILITY - T3",
                'work_sub_unit_code' => "60056068",
                'work_sub_unit_name' => "MECHANICAL FACILITY - T3",
                'organization_code' => "60056068",
                'organization_name' => "MECHANICAL FACILITY - T3",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056081",
                'work_unit_name' => "AIRSIDE INFRASTRUCTURE",
                'work_sub_unit_code' => "60056086",
                'work_sub_unit_name' => "SOUTH RUNWAY",
                'organization_code' => "60056081",
                'organization_name' => "AIRSIDE INFRASTRUCTURE",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056085",
                'work_unit_name' => "NORTH RUNWAY",
                'work_sub_unit_code' => "60056085",
                'work_sub_unit_name' => "NORTH RUNWAY",
                'organization_code' => "60056085",
                'organization_name' => "NORTH RUNWAY",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056087",
                'work_unit_name' => "AIRFIELD",
                'work_sub_unit_code' => "60056087",
                'work_sub_unit_name' => "AIRFIELD",
                'organization_code' => "60056087",
                'organization_name' => "AIRFIELD",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056091",
                'work_unit_name' => "ACCESIBILITY & ROAD",
                'work_sub_unit_code' => "60056091",
                'work_sub_unit_name' => "ACCESIBILITY & ROAD",
                'organization_code' => "60056091",
                'organization_name' => "ACCESIBILITY & ROAD",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056092",
                'work_unit_name' => "ENVIRONMENT",
                'work_sub_unit_code' => "60056092",
                'work_sub_unit_name' => "ENVIRONMENT",
                'organization_code' => "60056092",
                'organization_name' => "ENVIRONMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056093",
                'work_unit_name' => "LANDSCAPE",
                'work_sub_unit_code' => "60056093",
                'work_sub_unit_name' => "LANDSCAPE",
                'organization_code' => "60056093",
                'organization_name' => "LANDSCAPE",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056097",
                'work_unit_name' => "ENERGY & POWER SUPPLY",
                'work_sub_unit_code' => "60076547",
                'work_sub_unit_name' => "HIGH & MEDIUM VOLTAGE STATION",
                'organization_code' => "60056097",
                'organization_name' => "ENERGY & POWER SUPPLY",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056098",
                'work_unit_name' => "MECHANICAL & AIRPORT EQUIPMENT",
                'work_sub_unit_code' => "60076712",
                'work_sub_unit_name' => "GROUND SUPPORT SYSTEM",
                'organization_code' => "60056098",
                'organization_name' => "MECHANICAL & AIRPORT EQUIPMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056107",
                'work_unit_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'work_sub_unit_code' => "60056107",
                'work_sub_unit_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'organization_code' => "60056107",
                'organization_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056108",
                'work_unit_name' => "AIRPORT SECURITY",
                'work_sub_unit_code' => "60056108",
                'work_sub_unit_name' => "AIRPORT SECURITY",
                'organization_code' => "60056108",
                'organization_name' => "AIRPORT SECURITY",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056119",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60056175",
                'work_sub_unit_name' => "Terminal & General Building",
                'organization_code' => "60056119",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056122",
                'work_unit_name' => "Electronic Facility & IT",
                'work_sub_unit_code' => "60056122",
                'work_sub_unit_name' => "Electronic Facility & IT",
                'organization_code' => "60056122",
                'organization_name' => "Electronic Facility & IT",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056123",
                'work_unit_name' => "Electrical & Mechanical Facility",
                'work_sub_unit_code' => "60056123",
                'work_sub_unit_name' => "Electrical & Mechanical Facility",
                'organization_code' => "60056123",
                'organization_name' => "Electrical & Mechanical Facility",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056124",
                'work_unit_name' => "Airside Infrastructure & Accesibility",
                'work_sub_unit_code' => "60056124",
                'work_sub_unit_name' => "Airside Infrastructure & Accesibility",
                'organization_code' => "60056124",
                'organization_name' => "Airside Infrastructure & Accesibility",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056182",
                'work_unit_name' => "Financial Management",
                'work_sub_unit_code' => "60056182",
                'work_sub_unit_name' => "Financial Management",
                'organization_code' => "60056182",
                'organization_name' => "Financial Management",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056183",
                'work_unit_name' => "Financial Control",
                'work_sub_unit_code' => "60056183",
                'work_sub_unit_name' => "Financial Control",
                'organization_code' => "60056183",
                'organization_name' => "Financial Control",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056184",
                'work_unit_name' => "Human Resources & General Affairs",
                'work_sub_unit_code' => "60056184",
                'work_sub_unit_name' => "Human Resources & General Affairs",
                'organization_code' => "60056184",
                'organization_name' => "Human Resources & General Affairs",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056185",
                'work_unit_name' => "Community Development",
                'work_sub_unit_code' => "60056185",
                'work_sub_unit_name' => "Community Development",
                'organization_code' => "60056185",
                'organization_name' => "Community Development",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056197",
                'work_unit_name' => "PROCUREMENT & LEGAL",
                'work_sub_unit_code' => "60056197",
                'work_sub_unit_name' => "PROCUREMENT & LEGAL",
                'organization_code' => "60056197",
                'organization_name' => "PROCUREMENT & LEGAL",
                'personal_area_code' => "BDO",
                'personal_area_name' => "Bandara Husein Sastranegara"
            ],
            [
                'work_unit_code' => "60056211",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60056218",
                'work_sub_unit_name' => "TERMINAL & GENERAL BUILDING",
                'organization_code' => "60056211",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "PNK",
                'personal_area_name' => "Bandara Supadio"
            ],
            [
                'work_unit_code' => "60056214",
                'work_unit_name' => "ELECTRONIC FACILITY & IT",
                'work_sub_unit_code' => "60056214",
                'work_sub_unit_name' => "ELECTRONIC FACILITY & IT",
                'organization_code' => "60056214",
                'organization_name' => "ELECTRONIC FACILITY & IT",
                'personal_area_code' => "PNK",
                'personal_area_name' => "Bandara Supadio"
            ],
            [
                'work_unit_code' => "60056216",
                'work_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'work_sub_unit_code' => "60056216",
                'work_sub_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'organization_code' => "60056216",
                'organization_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'personal_area_code' => "PNK",
                'personal_area_name' => "Bandara Supadio"
            ],
            [
                'work_unit_code' => "60056217",
                'work_unit_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILIT",
                'work_sub_unit_code' => "60056217",
                'work_sub_unit_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILIT",
                'organization_code' => "60056217",
                'organization_name' => "AIRSIDE INFRASTRUCTURE & ACCESIBILIT",
                'personal_area_code' => "PNK",
                'personal_area_name' => "Bandara Supadio"
            ],
            [
                'work_unit_code' => "60056241",
                'work_unit_name' => "SAFETY & RISK MANAGEMENT",
                'work_sub_unit_code' => "60056241",
                'work_sub_unit_name' => "SAFETY & RISK MANAGEMENT",
                'organization_code' => "60056241",
                'organization_name' => "SAFETY & RISK MANAGEMENT",
                'personal_area_code' => "",
                "personal_area_name" => null
            ],
            [
                'work_unit_code' => "60056266",
                'work_unit_name' => "SANITATION FACILITY",
                'work_sub_unit_code' => "60056266",
                'work_sub_unit_name' => "SANITATION FACILITY",
                'organization_code' => "60056266",
                'organization_name' => "SANITATION FACILITY",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056267",
                'work_unit_name' => "WATER TREATMENT",
                'work_sub_unit_code' => "60056267",
                'work_sub_unit_name' => "WATER TREATMENT",
                'organization_code' => "60056267",
                'organization_name' => "WATER TREATMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056271",
                'work_unit_name' => "IT PUBLIC SERVICE & SECURITY",
                'work_sub_unit_code' => "60056281",
                'work_sub_unit_name' => "BAGGAGE HANDLING SYSTEM",
                'organization_code' => "60056271",
                'organization_name' => "IT PUBLIC SERVICE & SECURITY",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056278",
                'work_unit_name' => "PUBLIC SERVICE & IT SYSTEM",
                'work_sub_unit_code' => "60056278",
                'work_sub_unit_name' => "PUBLIC SERVICE & IT SYSTEM",
                'organization_code' => "60056278",
                'organization_name' => "PUBLIC SERVICE & IT SYSTEM",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056308",
                'work_unit_name' => "GENERAL ACCOUNTING",
                'work_sub_unit_code' => "60056308",
                'work_sub_unit_name' => "GENERAL ACCOUNTING",
                'organization_code' => "60056308",
                'organization_name' => "GENERAL ACCOUNTING",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056368",
                'work_unit_name' => "AIRPORT OPERATION & SERVICE",
                'work_sub_unit_code' => "60056371",
                'work_sub_unit_name' => "AIRSIDE OPERATION",
                'organization_code' => "60056368",
                'organization_name' => "AIRPORT OPERATION & SERVICE",
                'personal_area_code' => "PGK",
                'personal_area_name' => "Bandara Depati Amir"
            ],
            [
                'work_unit_code' => "60056378",
                'work_unit_name' => "MANAGEMENT ACCOUNTING",
                'work_sub_unit_code' => "60056378",
                'work_sub_unit_name' => "MANAGEMENT ACCOUNTING",
                'organization_code' => "60056378",
                'organization_name' => "MANAGEMENT ACCOUNTING",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056385",
                'work_unit_name' => "ACCOUNT RECEIVABLE",
                'work_sub_unit_code' => "60056386",
                'work_sub_unit_name' => "RECEIVABLE ADMINISTRATION",
                'organization_code' => "60056385",
                'organization_name' => "ACCOUNT RECEIVABLE",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056423",
                'work_unit_name' => "ASSETS MANAGEMENT",
                'work_sub_unit_code' => "60056478",
                'work_sub_unit_name' => "LAND MANAGEMENT",
                'organization_code' => "60056423",
                'organization_name' => "ASSETS MANAGEMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056425",
                'work_unit_name' => "ELECTRONIC FACILITY & IT",
                'work_sub_unit_code' => "60056425",
                'work_sub_unit_name' => "ELECTRONIC FACILITY & IT",
                'organization_code' => "60056425",
                'organization_name' => "ELECTRONIC FACILITY & IT",
                'personal_area_code' => "PGK",
                'personal_area_name' => "Bandara Depati Amir"
            ],
            [
                'work_unit_code' => "60056426",
                'work_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'work_sub_unit_code' => "60056426",
                'work_sub_unit_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'organization_code' => "60056426",
                'organization_name' => "ELECTRICAL & MECHANICAL FACILITY",
                'personal_area_code' => "PGK",
                'personal_area_name' => "Bandara Depati Amir"
            ],
            [
                'work_unit_code' => "60056427",
                'work_unit_name' => "INFRASTRUCTURE",
                'work_sub_unit_code' => "60056427",
                'work_sub_unit_name' => "INFRASTRUCTURE",
                'organization_code' => "60056427",
                'organization_name' => "INFRASTRUCTURE",
                'personal_area_code' => "PGK",
                'personal_area_name' => "Bandara Depati Amir"
            ],
            [
                'work_unit_code' => "60056449",
                'work_unit_name' => "SAFETY, RISK, & QUALITY CONTROL",
                'work_sub_unit_code' => "60056508",
                'work_sub_unit_name' => "MAINTENANCE QUALITY CONTROL",
                'organization_code' => "60056449",
                'organization_name' => "SAFETY, RISK, & QUALITY CONTROL",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056455",
                'work_unit_name' => "INVENTORY MANAGEMENT",
                'work_sub_unit_code' => "60056455",
                'work_sub_unit_name' => "INVENTORY MANAGEMENT",
                'organization_code' => "60056455",
                'organization_name' => "INVENTORY MANAGEMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056459",
                'work_unit_name' => "MECHANICAL FACILITY-T1",
                'work_sub_unit_code' => "60056459",
                'work_sub_unit_name' => "MECHANICAL FACILITY-T1",
                'organization_code' => "60056459",
                'organization_name' => "MECHANICAL FACILITY-T1",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056501",
                'work_unit_name' => "PROCUREMENT",
                'work_sub_unit_code' => "60056516",
                'work_sub_unit_name' => "OPERATION & SERVICE PROCUREMENT",
                'organization_code' => "60056501",
                'organization_name' => "PROCUREMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056503",
                'work_unit_name' => "SAFETY & RISK MANAGEMENT",
                'work_sub_unit_code' => "60056503",
                'work_sub_unit_name' => "SAFETY & RISK MANAGEMENT",
                'organization_code' => "60056503",
                'organization_name' => "SAFETY & RISK MANAGEMENT",
                'personal_area_code' => "",
                "personal_area_name" => null
            ],
            [
                'work_unit_code' => "60056510",
                'work_unit_name' => "AIRPORT DATA MANAGEMENT",
                'work_sub_unit_code' => "60056510",
                'work_sub_unit_name' => "AIRPORT DATA MANAGEMENT",
                'organization_code' => "60056510",
                'organization_name' => "AIRPORT DATA MANAGEMENT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056522",
                'work_unit_name' => "BRANCH COMMUNICATION",
                'work_sub_unit_code' => "60056522",
                'work_sub_unit_name' => "BRANCH COMMUNICATION",
                'organization_code' => "60056522",
                'organization_name' => "BRANCH COMMUNICATION",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056528",
                'work_unit_name' => "AGREEMENT & COMMERCIAL CONTRACT",
                'work_sub_unit_code' => "60056528",
                'work_sub_unit_name' => "AGREEMENT & COMMERCIAL CONTRACT",
                'organization_code' => "60056528",
                'organization_name' => "AGREEMENT & COMMERCIAL CONTRACT",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60056711",
                'work_unit_name' => "BANDARA BANYUWANGI",
                'work_sub_unit_code' => "60085926",
                'work_sub_unit_name' => "AIRPORT OPERATION & RESCUE FIRE FIGHTING",
                'organization_code' => "60056711",
                'organization_name' => "BANDARA BANYUWANGI",
                'personal_area_code' => "BWX",
                'personal_area_name' => "Bandara Banyuwangi"
            ],
            [
                'work_unit_code' => "60072843",
                'work_unit_name' => "BANDARA INTERNASIONAL JAWA BARAT",
                'work_sub_unit_code' => "60073134",
                'work_sub_unit_name' => "SAFETY & RISK MANAGEMENT",
                'organization_code' => "60072843",
                'organization_name' => "BANDARA INTERNASIONAL JAWA BARAT",
                'personal_area_code' => "KJT",
                'personal_area_name' => "Bandara Kertajati"
            ],
            [
                'work_unit_code' => "60072844",
                'work_unit_name' => "OPERATION & SERVICE",
                'work_sub_unit_code' => "60073575",
                'work_sub_unit_name' => "AIRPORT RESCUE & FIRE FIGHTING",
                'organization_code' => "60072844",
                'organization_name' => "OPERATION & SERVICE",
                'personal_area_code' => "KJT",
                'personal_area_name' => "Bandara Kertajati"
            ],
            [
                'work_unit_code' => "60072845",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60073131",
                'work_sub_unit_name' => "ELECTRONIC FACILITY & IT",
                'organization_code' => "60072845",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "KJT",
                'personal_area_name' => "Bandara Kertajati"
            ],
            [
                'work_unit_code' => "60074716",
                'work_unit_name' => "BANDARA TJILIK RIWUT",
                'work_sub_unit_code' => "60074732",
                'work_sub_unit_name' => "SAFETY, RISK & QUALITY CONTROL",
                'organization_code' => "60074716",
                'organization_name' => "BANDARA TJILIK RIWUT",
                'personal_area_code' => "PKY",
                'personal_area_name' => "Bandara Tjilik Riwut"
            ],
            [
                'work_unit_code' => "60074718",
                'work_unit_name' => "AIRPORT OPERATION & SERVICE",
                'work_sub_unit_code' => "60074722",
                'work_sub_unit_name' => "TERMINAL & LANDSIDE SERVICE",
                'organization_code' => "60074718",
                'organization_name' => "AIRPORT OPERATION & SERVICE",
                'personal_area_code' => "PKY",
                'personal_area_name' => "Bandara Tjilik Riwut"
            ],
            [
                'work_unit_code' => "60074723",
                'work_unit_name' => "AIRPORT MAINTENANCE",
                'work_sub_unit_code' => "60074724",
                'work_sub_unit_name' => "ELECTRONIC FACILITY & IT",
                'organization_code' => "60074723",
                'organization_name' => "AIRPORT MAINTENANCE",
                'personal_area_code' => "PKY",
                'personal_area_name' => "Bandara Tjilik Riwut"
            ],
            [
                'work_unit_code' => "60074727",
                'work_unit_name' => "FINANCE & HUMAN RESOURCES",
                'work_sub_unit_code' => "60074729",
                'work_sub_unit_name' => "FINANCIAL MANAGEMENT",
                'organization_code' => "60074727",
                'organization_name' => "FINANCE & HUMAN RESOURCES",
                'personal_area_code' => "PKY",
                'personal_area_name' => "Bandara Tjilik Riwut"
            ],
            [
                'work_unit_code' => "60076494",
                'work_unit_name' => "PUBLIC TRANSPORTATION SERVICE",
                'work_sub_unit_code' => "60076507",
                'work_sub_unit_name' => "PERSONAL PUBLIC TRANSPORTATION",
                'organization_code' => "60076494",
                'organization_name' => "PUBLIC TRANSPORTATION SERVICE",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60076575",
                'work_unit_name' => "ELECTRICAL UTILITY & VISUAL AID",
                'work_sub_unit_code' => "60076578",
                'work_sub_unit_name' => "UPS & CONVERTER",
                'organization_code' => "60076575",
                'organization_name' => "ELECTRICAL UTILITY & VISUAL AID",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60076712",
                'work_unit_name' => "GROUND SUPPORT SYSTEM",
                'work_sub_unit_code' => "60076712",
                'work_sub_unit_name' => "GROUND SUPPORT SYSTEM",
                'organization_code' => "60076712",
                'organization_name' => "GROUND SUPPORT SYSTEM",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60077772",
                'work_unit_name' => "ADJACENT BUSINESS DIVISION",
                'work_sub_unit_code' => "60077910",
                'work_sub_unit_name' => "ADJACENT BUSINESS PLANNING & PERFORMANCE",
                'organization_code' => "60077772",
                'organization_name' => "ADJACENT BUSINESS DIVISION",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077791",
                'work_unit_name' => "AIRPORT GLOBAL SERVICE",
                'work_sub_unit_code' => "60077799",
                'work_sub_unit_name' => "GLOBAL SERVICE STANDARDIZATION",
                'organization_code' => "60077791",
                'organization_name' => "AIRPORT GLOBAL SERVICE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077823",
                'work_unit_name' => "AIRPORT ENGINEERING DEVELOPMENT",
                'work_sub_unit_code' => "60078206",
                'work_sub_unit_name' => "ENGINEERING STANDARDIZATION",
                'organization_code' => "60077823",
                'organization_name' => "AIRPORT ENGINEERING DEVELOPMENT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077824",
                'work_unit_name' => "AIRPORT MAINTENANCE POLICY",
                'work_sub_unit_code' => "60078209",
                'work_sub_unit_name' => "MAINTENANCE PLANNING",
                'organization_code' => "60077824",
                'organization_name' => "AIRPORT MAINTENANCE POLICY",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077871",
                'work_unit_name' => "INTERNAL AUDIT",
                'work_sub_unit_code' => "60082793",
                'work_sub_unit_name' => "INFRASTRUCTURE, FAC., IT & PROJECT AUDIT",
                'organization_code' => "60077871",
                'organization_name' => "INTERNAL AUDIT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077892",
                'work_unit_name' => "HUMAN CAPITAL STRATEGY",
                'work_sub_unit_code' => "60077897",
                'work_sub_unit_name' => "HUMAN CAPITAL POLICY",
                'organization_code' => "60077892",
                'organization_name' => "HUMAN CAPITAL STRATEGY",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077893",
                'work_unit_name' => "CORPORATE TALENT MANAGEMENT",
                'work_sub_unit_code' => "60077893",
                'work_sub_unit_name' => "CORPORATE TALENT MANAGEMENT",
                'organization_code' => "60077893",
                'organization_name' => "CORPORATE TALENT MANAGEMENT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077901",
                'work_unit_name' => "INFORMATION SYSTEM DIVISION",
                'work_sub_unit_code' => "60077916",
                'work_sub_unit_name' => "INFORMATION SYSTEM MON. & EV.",
                'organization_code' => "60077901",
                'organization_name' => "INFORMATION SYSTEM DIVISION",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077909",
                'work_unit_name' => "AIRPORT SERVICE DIVISION",
                'work_sub_unit_code' => "60077917",
                'work_sub_unit_name' => "SERVICE PLANNING & PERFORMANCE",
                'organization_code' => "60077909",
                'organization_name' => "AIRPORT SERVICE DIVISION",
                'personal_area_code' => "REG",
                'personal_area_name' => "Airport Region"
            ],
            [
                'work_unit_code' => "60077923",
                'work_unit_name' => "AIRPORT LEARNING CENTER",
                'work_sub_unit_code' => "60077950",
                'work_sub_unit_name' => "LEADERSHIP & SUPPORTING PROGRAM",
                'organization_code' => "60077923",
                'organization_name' => "AIRPORT LEARNING CENTER",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077933",
                'work_unit_name' => "FINANCE",
                'work_sub_unit_code' => "60083297",
                'work_sub_unit_name' => "ASSET ACCELERATION PARTNERSHIP TEAM",
                'organization_code' => "60077933",
                'organization_name' => "FINANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077934",
                'work_unit_name' => "FINANCIAL & LOGISTIC POLICY",
                'work_sub_unit_code' => "60077940",
                'work_sub_unit_name' => "INVESTMENT & FUNDING",
                'organization_code' => "60077934",
                'organization_name' => "FINANCIAL & LOGISTIC POLICY",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077935",
                'work_unit_name' => "ASSETS MANAGEMENT",
                'work_sub_unit_code' => "60080655",
                'work_sub_unit_name' => "LAND MANAGEMENT",
                'organization_code' => "60077935",
                'organization_name' => "ASSETS MANAGEMENT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077936",
                'work_unit_name' => "PARENTING & SUBSIDIARY PERFORMANCE",
                'work_sub_unit_code' => "60077948",
                'work_sub_unit_name' => "PARENTING OPERATION",
                'organization_code' => "60077936",
                'organization_name' => "PARENTING & SUBSIDIARY PERFORMANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077959",
                'work_unit_name' => "AIRPORT DESIGN DIVISION",
                'work_sub_unit_code' => "60077962",
                'work_sub_unit_name' => "ELECTRONIC DESIGN",
                'organization_code' => "60077959",
                'organization_name' => "AIRPORT DESIGN DIVISION",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077969",
                'work_unit_name' => "HUMAN CAPITAL CENTER",
                'work_sub_unit_code' => "60077970",
                'work_sub_unit_name' => "PERSONAL WELFARE",
                'organization_code' => "60077969",
                'organization_name' => "HUMAN CAPITAL CENTER",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077981",
                'work_unit_name' => "COMMERCIAL STRATEGY",
                'work_sub_unit_code' => "60077988",
                'work_sub_unit_name' => "AERONAUTICAL STRATEGY",
                'organization_code' => "60077981",
                'organization_name' => "COMMERCIAL STRATEGY",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077982",
                'work_unit_name' => "COMMERCIAL POLICY",
                'work_sub_unit_code' => "60077992",
                'work_sub_unit_name' => "AERONAUTICAL POLICY",
                'organization_code' => "60077982",
                'organization_name' => "COMMERCIAL POLICY",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60077983",
                'work_unit_name' => "COMMERCIAL PERFORMANCE",
                'work_sub_unit_code' => "60077998",
                'work_sub_unit_name' => "NON AERONAUTICAL PERFORMANCE",
                'organization_code' => "60077983",
                'organization_name' => "COMMERCIAL PERFORMANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078007",
                'work_unit_name' => "FINANCE CENTER",
                'work_sub_unit_code' => "60078009",
                'work_sub_unit_name' => "TAX MANAGEMENT",
                'organization_code' => "60078007",
                'organization_name' => "FINANCE CENTER",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078015",
                'work_unit_name' => "SUPPLY CENTER",
                'work_sub_unit_code' => "60078018",
                'work_sub_unit_name' => "SUPPLY ASSISTANCE",
                'organization_code' => "60078015",
                'organization_name' => "SUPPLY CENTER",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078029",
                'work_unit_name' => "AIRPORT OPERATION DIVISION",
                'work_sub_unit_code' => "60078033",
                'work_sub_unit_name' => "AIRSIDE & LANDSIDE OPERATION",
                'organization_code' => "60078029",
                'organization_name' => "AIRPORT OPERATION DIVISION",
                'personal_area_code' => "REG",
                'personal_area_name' => "Airport Region"
            ],
            [
                'work_unit_code' => "60078047",
                'work_unit_name' => "AIRPORT MAINTENANCE DIVISION",
                'work_sub_unit_code' => "60078051",
                'work_sub_unit_name' => "ELECTRICAL & MECHANICAL MAINTENANCE",
                'organization_code' => "60078047",
                'organization_name' => "AIRPORT MAINTENANCE DIVISION",
                'personal_area_code' => "REG",
                'personal_area_name' => "Airport Region"
            ],
            [
                'work_unit_code' => "60078077",
                'work_unit_name' => "AIRPORT OPERATION POLICY",
                'work_sub_unit_code' => "60078077",
                'work_sub_unit_name' => "AIRPORT OPERATION POLICY",
                'organization_code' => "60078077",
                'organization_name' => "AIRPORT OPERATION POLICY",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078078",
                'work_unit_name' => "OPERATION & SERVICE QUALITY ASSURANCE",
                'work_sub_unit_code' => "60078117",
                'work_sub_unit_name' => "SERVICE ASSURANCE",
                'organization_code' => "60078078",
                'organization_name' => "OPERATION & SERVICE QUALITY ASSURANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078200",
                'work_unit_name' => "ENGINEERING & FACILITY QUALITY ASSURANCE",
                'work_sub_unit_code' => "60078216",
                'work_sub_unit_name' => "ENGINEERING ASSURANCE",
                'organization_code' => "60078200",
                'organization_name' => "ENGINEERING & FACILITY QUALITY ASSURANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078223",
                'work_unit_name' => "TRANSFORMATION & STRATEGIC PORTFOLIO",
                'work_sub_unit_code' => "60082776",
                'work_sub_unit_name' => "CGK PARTNERSHIP TEAM",
                'organization_code' => "60078223",
                'organization_name' => "TRANSFORMATION & STRATEGIC PORTFOLIO",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078224",
                'work_unit_name' => "CORPORATE PLANNING GROUP",
                'work_sub_unit_code' => "60082320",
                'work_sub_unit_name' => "DATA MANAGEMENT & IT STRATEGY",
                'organization_code' => "60078224",
                'organization_name' => "CORPORATE PLANNING GROUP",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078225",
                'work_unit_name' => "CORPORATE DEVELOPMENT GROUP",
                'work_sub_unit_code' => "60078239",
                'work_sub_unit_name' => "BUSINESS DEVELOPMENT",
                'organization_code' => "60078225",
                'organization_name' => "CORPORATE DEVELOPMENT GROUP",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078226",
                'work_unit_name' => "CORPORATE TRANSFORMATION GROUP",
                'work_sub_unit_code' => "60078241",
                'work_sub_unit_name' => "CHANGE MANAGEMENT",
                'organization_code' => "60078226",
                'organization_name' => "CORPORATE TRANSFORMATION GROUP",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078258",
                'work_unit_name' => "CORPORATE COMMUNICATION",
                'work_sub_unit_code' => "60078262",
                'work_sub_unit_name' => "CORPORATE OFFICE SUPPORT",
                'organization_code' => "60078258",
                'organization_name' => "CORPORATE COMMUNICATION",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078259",
                'work_unit_name' => "LEGAL & COMPLIANCE",
                'work_sub_unit_code' => "60078264",
                'work_sub_unit_name' => "CONTRACT & AGREEMENT",
                'organization_code' => "60078259",
                'organization_name' => "LEGAL & COMPLIANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078260",
                'work_unit_name' => "LEGAL AID & INSTITUTIONAL RELATION",
                'work_sub_unit_code' => "60078266",
                'work_sub_unit_name' => "INSTITUTIONAL RELATION",
                'organization_code' => "60078260",
                'organization_name' => "LEGAL AID & INSTITUTIONAL RELATION",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60078278",
                'work_unit_name' => "CORPORATE SAFETY MANAGEMENT",
                'work_sub_unit_code' => "60078279",
                'work_sub_unit_name' => "SAFETY MANAGEMENT SYSTEM",
                'organization_code' => "60078278",
                'organization_name' => "CORPORATE SAFETY MANAGEMENT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60079364",
                'work_unit_name' => "BANDARA H.A.S HANANDJOEDDIN",
                'work_sub_unit_code' => "60079370",
                'work_sub_unit_name' => "AIRPORT MAINTENANCE",
                'organization_code' => "60079364",
                'organization_name' => "BANDARA H.A.S HANANDJOEDDIN",
                'personal_area_code' => "TJQ",
                'personal_area_name' => "Bandar Udara Internasional H.AS. Hanandjoeddin"
            ],
            [
                'work_unit_code' => "60079433",
                'work_unit_name' => "BANDARA FATMAWATI SOEKARNO",
                'work_sub_unit_code' => "60079436",
                'work_sub_unit_name' => "AIRPORT MAINTENANCE",
                'organization_code' => "60079433",
                'organization_name' => "BANDARA FATMAWATI SOEKARNO",
                'personal_area_code' => "BKS",
                'personal_area_name' => "Bandar Udara Fatmawati Soekarno"
            ],
            [
                'work_unit_code' => "60081386",
                'work_unit_name' => "PROJECT IMPLEMENTATION",
                'work_sub_unit_code' => "60081565",
                'work_sub_unit_name' => "PIU - PDG",
                'organization_code' => "60081386",
                'organization_name' => "PROJECT IMPLEMENTATION",
                'personal_area_code' => "REG",
                'personal_area_name' => "Airport Region"
            ],
            [
                'work_unit_code' => "60081411",
                'work_unit_name' => "PROJECT EVALUATION",
                'work_sub_unit_code' => "60081420",
                'work_sub_unit_name' => "PROJECT EVALUATION - NON CGK",
                'organization_code' => "60081411",
                'organization_name' => "PROJECT EVALUATION",
                'personal_area_code' => "REG",
                'personal_area_name' => "Airport Region"
            ],
            [
                'work_unit_code' => "60081535",
                'work_unit_name' => "AIRPORT OPERATION CONTROL CENTER",
                'work_sub_unit_code' => "60081537",
                'work_sub_unit_name' => "OPERATION PERFORMANCE",
                'organization_code' => "60081535",
                'organization_name' => "AIRPORT OPERATION CONTROL CENTER",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60081536",
                'work_unit_name' => "OPERATION CONTROL",
                'work_sub_unit_code' => "60081536",
                'work_sub_unit_name' => "OPERATION CONTROL",
                'organization_code' => "60081536",
                'organization_name' => "OPERATION CONTROL",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ],
            [
                'work_unit_code' => "60081712",
                'work_unit_name' => "COMMERCIAL SERVICE DIVISION",
                'work_sub_unit_code' => "60081762",
                'work_sub_unit_name' => "COMMERCIAL - PKU",
                'organization_code' => "60081712",
                'organization_name' => "COMMERCIAL SERVICE DIVISION",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60081713",
                'work_unit_name' => "AERONAUTICAL BUSINESS",
                'work_sub_unit_code' => "60081743",
                'work_sub_unit_name' => "PJP2U & COUNTER INTERNATIONAL - CGK",
                'organization_code' => "60081713",
                'organization_name' => "AERONAUTICAL BUSINESS",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60081714",
                'work_unit_name' => "NON AERONAUTICAL BUSINESS",
                'work_sub_unit_code' => "60081749",
                'work_sub_unit_name' => "LAND TRANSPORTATION - CGK",
                'organization_code' => "60081714",
                'organization_name' => "NON AERONAUTICAL BUSINESS",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60081715",
                'work_unit_name' => "CARGO & AERONAUTICAL SUPPORT",
                'work_sub_unit_code' => "60081954",
                'work_sub_unit_name' => "AERONAUTICAL SUPPORT - CGK",
                'organization_code' => "60081715",
                'organization_name' => "CARGO & AERONAUTICAL SUPPORT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60081726",
                'work_unit_name' => "PROJECT & BUSINESS",
                'work_sub_unit_code' => "60081731",
                'work_sub_unit_name' => "DATA & BUSINESS ANALYSIS AERO. & CARGO",
                'organization_code' => "60081726",
                'organization_name' => "PROJECT & BUSINESS",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60082696",
                'work_unit_name' => "CGK CARGO VILLAGE PARTNERSHIP TEAM",
                'work_sub_unit_code' => "60085275",
                'work_sub_unit_name' => "CGK CARGO VILLAGE PARTNERSHIP 1",
                'organization_code' => "60082696",
                'organization_name' => "CGK CARGO VILLAGE PARTNERSHIP TEAM",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60082966",
                'work_unit_name' => "AUDIT DEVELOPMENT & QUALITY ASSURANCE",
                'work_sub_unit_code' => "60082966",
                'work_sub_unit_name' => "AUDIT DEVELOPMENT & QUALITY ASSURANCE",
                'organization_code' => "60082966",
                'organization_name' => "AUDIT DEVELOPMENT & QUALITY ASSURANCE",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60082972",
                'work_unit_name' => "CORPORATE RISK MANAGEMENT",
                'work_sub_unit_code' => "60082976",
                'work_sub_unit_name' => "OPERATIONAL RISK MANAGEMENT",
                'organization_code' => "60082972",
                'organization_name' => "CORPORATE RISK MANAGEMENT",
                'personal_area_code' => "PST",
                "personal_area_name" => null
            ],
            [
                'work_unit_code' => "60082985",
                'work_unit_name' => "CORPORATE SAFETY & QUALITY MANAGEMENT",
                'work_sub_unit_code' => "60083005",
                'work_sub_unit_name' => "QUALITY MANAGEMENT SYSTEM",
                'organization_code' => "60082985",
                'organization_name' => "CORPORATE SAFETY & QUALITY MANAGEMENT",
                'personal_area_code' => "PST",
                'personal_area_name' => "Kantor Pusat"
            ],
            [
                'work_unit_code' => "60090126",
                'work_unit_name' => "GENERAL MANAGER",
                'work_sub_unit_code' => "60090126",
                'work_sub_unit_name' => "GENERAL MANAGER",
                'organization_code' => "60090126",
                'organization_name' => "GENERAL MANAGER",
                'personal_area_code' => "CGK",
                'personal_area_name' => "Bandara Internasional Soekarno Hatta"
            ]
        ];

        if (Company::count() == 0) {
            Company::insert($companies);
        }
    }
}
