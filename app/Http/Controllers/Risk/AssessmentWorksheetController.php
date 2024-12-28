<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Master\BUMNScale;
use App\Models\Master\ControlEffectivenessAssessment;
use App\Models\Master\ExistingControlType;
use App\Models\Master\Heatmap;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\KBUMNTarget;
use App\Models\Master\KRIThreshold;
use App\Models\Master\KRIUnit;
use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentType;
use App\Models\Master\RKAPProgramType;
use App\Models\Risk\Assessment\Worksheet;
use App\Models\Risk\Assessment\WorksheetIdentificationIncidentMitigation;
use App\Models\Risk\Assessment\WorksheetIdentificationInherent;
use App\Models\Risk\Assessment\WorksheetIdentificationResidual;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssessmentWorksheetController extends Controller
{
    public function index()
    {
        $title = 'Form Kertas Kerja';

        $worksheet_number = Worksheet::activeYear()->count() + 1;

        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $existing_control_types = ExistingControlType::all();
        $kbumn_targets = KBUMNTarget::all();
        $kri_thresholds = KRIThreshold::all();
        $kri_units = KRIUnit::all();
        $bumn_scales = BUMNScale::all();
        $heatmaps = Heatmap::all();
        $control_effectiveness_assessments = ControlEffectivenessAssessment::all();
        $rkap_program_types = RKAPProgramType::with('children')->parentOnly()->get();
        $risk_treatment_types = RiskTreatmentType::all();
        $risk_treatment_options = RiskTreatmentOption::all();

        return view('risk.assessment.worksheet.index', compact(
            'title',
            'worksheet_number',
            'kbumn_risk_categories',
            'existing_control_types',
            'kbumn_targets',
            'kri_thresholds',
            'kri_units',
            'control_effectiveness_assessments',
            'bumn_scales',
            'heatmaps',
            'rkap_program_types',
            'risk_treatment_types',
            'risk_treatment_options'
        ));
    }

    public function create()
    {
        return view('risk.assessment.worksheet.index');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $company = auth()->user()->company()->select(
                'work_unit_code',
                'work_unit_name',
                'work_sub_unit_code',
                'work_sub_unit_name',
                'organization_code',
                'organization_name',
                'personal_area_code',
                'personal_area_name',
            )->first();

            $worksheet = Worksheet::create([
                'worksheet_code' =>  'WR/' . date('Y') . '/' . Str::random(8),
                'status' => DocumentStatus::DRAFT->value
            ] + $company->toArray());

            $target = $worksheet->target()->create([
                'body' => $request->target_body
            ]);

            $strategies = [];
            foreach ($request->strategies as $index => $items) {
                $strategy = [];
                foreach ($items as $key => $value) {
                    $strategy[str_replace('strategy_', '', $key)] = $value;
                }

                $strategies[] = $strategy;
            }

            $res = $target->strategies()->createMany($strategies);

            $identification = [];
            foreach ($request->identification as $key => $value) {
                $key = $key != 'kbumn_target' ? str_replace('kbumn_', '', $key) : $key;

                $identification[$key . '_id'] = $value == 'Pilih' || !$value ? null : $value;
            }
            $identification = $target->identification()->create($identification);

            $incidents = [];
            foreach ($request->identifications as $index => $item) {
                $incident = [];
                foreach ($item as $key => $value) {
                    if (str_contains($key, 'inherent') || str_contains($key, 'residual')) {
                        continue;
                    }

                    if (in_array($key, ['existing_control_type', 'control_effectiveness_assessment'])) {
                        $key = str_replace('risk_', '', $key);
                        $incident[$key . '_id'] = $value == 'Pilih' || !$value ? null : $value;
                    } else {
                        if ($key == 'key' || ($key == 'id' && !$value)) {
                            continue;
                        }

                        $incident[$key] = $value == 'Pilih' || !$value ? null : $value;
                    }
                }

                $incidents[] = $incident;
            }

            $incidents = $identification->incidents()->createMany($incidents);

            foreach ($request->identifications as $index => $item) {
                $inherent = [];
                $residual = [];
                $residuals = [];
                foreach ($item as $key => $value) {
                    if (!str_contains($key, 'inherent')) {
                        if ($key == 'residual') {
                            foreach ($value as $itemKey => $items) {
                                $empty = false;
                                if (!$items) {
                                    continue;
                                }

                                foreach ($items as $k => $v) {
                                    if ($k == 'impact_scale' && ($v == 'Pilih' || !$v)) {
                                        $empty = true;
                                    }


                                    $k = $k == 'impact_probability_scale' || $k == 'impact_scale' ? $k . '_id' : $k;
                                    $residual[$k] = $empty ? null : $v;
                                }

                                $residual['quarter'] = $itemKey;
                                $residuals[] = $residual;
                            }

                            $incidents[$index]->residuals()->createMany($residuals);
                        }
                        continue;
                    }

                    $key = str_replace('inherent_', '', $key);
                    $key = $key == 'impact_probability_scale' || $key == 'impact_scale' ? $key . '_id' : $key;

                    $inherent[$key] = $value == 'Pilih' || !$value ? null : $value;
                }

                $incidents[$index]->inherent()->create($inherent);
            }

            $mitigations = [];
            $incidents_array = $incidents->toArray();
            foreach ($request->mitigations as $index => $item) {
                $incidentIndex = array_search(
                    $item['risk_cause_number'],
                    array_column($incidents_array, 'risk_cause_number')
                );

                if ($incidentIndex === false) {
                    continue;
                }

                foreach ($item as $key => $value) {
                    $key =
                        $key == 'risk_treatment_option' ||
                        $key == 'risk_treatment_type' ||
                        $key == 'mitigation_rkap_program_type'
                        ? $key . '_id' : $key;

                    $mitigation[$key] = $value == 'Pilih' || !$value ? null : $value;
                }

                $mitigations[] = $incidents[$incidentIndex]->mitigations()->create($mitigation);
            }

            DB::commit();
            return response()->json($mitigations);

            return response()->json(['res' => $res, 'strategies' => $strategies]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
