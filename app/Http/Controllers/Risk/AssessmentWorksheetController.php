<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Enums\State;
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
use App\Models\Risk\Assessment\WorksheetHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssessmentWorksheetController extends Controller
{
    public function index()
    {
        $title = 'Form Kertas Kerja';

        $worksheet_number = Worksheet::subUnit(auth()->user()->sub_unit_code)->activeYear()->count() + 1;

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
            $user = auth()->user();
            $worksheetNumber = Worksheet::subUnit($user->sub_unit_code)->activeYear()->count() + 1;
            $worksheet = Worksheet::create([
                'worksheet_code' =>  'WR/' . date('Y') . '/' . Str::random(8),
                'worksheet_number' => $worksheetNumber,
                'company_code' => 'API',
                'company_name' => 'PT Aviasi Pariwisata Indonesia (Persero)',
                'status' => DocumentStatus::DRAFT->value
            ] + $user->only('organization_name', 'organization_code', 'unit_name', 'unit_code', 'sub_unit_name', 'sub_unit_code', 'personnel_area_name', 'personnel_area_code'));

            $target = $worksheet->target()->create([
                'body' => $request->context['target_body']
            ]);

            $strategies = [];
            foreach ($request->strategies as $index => $items) {
                $strategy = [];
                foreach ($items as $key => $value) {
                    $strategy[str_replace('strategy_', '', $key)] = $value;
                }

                $strategies[] = $strategy;
            }
            $strategies = $target->strategies()->createMany($strategies);

            $identification = ['created_by' => $user->employee_id];
            foreach ($request->identification as $key => $value) {
                if (str_contains($key, 'inherent') || str_contains($key, 'residual')) {
                    continue;
                }

                if (in_array($key, ['existing_control_type', 'kbumn_target', 'control_effectiveness_assessment'])) {
                    $identification[$key . '_id'] = $value == 'Pilih' || !$value ? null : $value;
                } else if (str_contains($key, 'risk_category')) {
                    $identification[str_replace('kbumn_', '', $key) . '_id'] = $value == 'Pilih' || !$value ? null : $value;
                } else {
                    if ($key == 'key' || ($key == 'id' && !$value)) {
                        continue;
                    }

                    $identification[$key] = $value == 'Pilih' || !$value ? null : $value;
                }
            }

            $inherent = [];
            $residuals = [];
            foreach ($request->identification as $key => $value) {
                $residual = [];
                if (str_contains($key, 'inherent')) {
                    $key = str_replace('inherent_', '', $key);
                    $key .= in_array($key, ['impact_probability_scale', 'impact_scale']) ? '_id' : '';

                    $inherent[$key] = $value == 'Pilih' || !$value ? null : $value;
                } else if (str_contains($key, 'residual')) {
                    foreach ($value as $quarter => $residual) {
                        if ($residual) {
                            $residual['quarter'] = $quarter;
                            foreach ($residual as $residualKey => $residualValue) {
                                $residualKey .= in_array($residualKey, ['impact_probability_scale', 'impact_scale']) ? '_id' : '';
                                $residual[$residualKey] = $residualValue;
                            }
                            $residuals[] = $residual;
                        }
                    }
                }
            }
            $identification = $target->identification()->create($identification);
            $inherent = $identification->inherent()->create($inherent);
            $residuals = $identification->residuals()->createMany($residuals);

            $incidents = [];
            foreach ($request->incidents as $index => $item) {
                $incident = [];
                foreach ($item as $key => $value) {
                    if ($key == 'key') continue;

                    $key = $key == 'kri_unit' ? $key . '_id' : $key;
                    $incident[$key] = $value;
                }

                $incidents[] = $incident;
            }

            $incidents = $identification->incidents()->createMany($incidents);

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

            $worksheet->last_history()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk admin',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => DocumentStatus::DRAFT->value,
                'note' => 'Membuat kertas kerja baru'
            ]);

            DB::commit();
            return response()->json(['data' => [
                'id' => $worksheet->getEncryptedId()
            ]]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(string $worksheet)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheet);

        $start = microtime(true);
        $worksheet->load([
            'target',
            'target.identification',
            'target.identification.kbumn_target',
            'target.identification.risk_category_t2',
            'target.identification.risk_category_t3',
            'target.identification.incidents',
            'target.identification.incidents.kri_unit',
            'target.identification.incidents.mitigations',
            'target.identification.incidents.mitigations.risk_treatment_option',
            'target.identification.incidents.mitigations.risk_treatment_type',
            'target.identification.incidents.mitigations.rkap_program_type',

            'target.identification.inherent',
            'target.identification.residuals',
            'target.identification.residuals.impact_scale',
            'target.identification.residuals.impact_probability_scale',
            'target.identification.incidents.mitigations',
            'target.identification.existing_control_type',
            'target.identification.control_effectiveness_assessment',
            'target.strategies',
            'histories.user',
            'last_history.user',
        ]);

        if (request()->ajax()) {

            $identification = $worksheet->target->identification->toArray();

            $identification['kbumn_target'] = $identification['kbumn_target_id'];
            $identification['kbumn_risk_category'] = $identification['risk_category_id'];
            $identification['kbumn_risk_category_t2'] = $identification['risk_category_t2_id'];
            $identification['kbumn_risk_category_t3'] = $identification['risk_category_t3_id'];
            $identification['existing_control_type'] = $identification['existing_control_type_id'];
            $identification['control_effectiveness_assessment'] = $identification['control_effectiveness_assessment_id'];

            $identification['inherent_body'] = $identification['inherent']['body'];
            $identification['inherent_impact_probability'] = $identification['inherent']['impact_probability'];
            $identification['inherent_impact_probability_scale'] = $identification['inherent']['impact_probability_scale_id'];
            $identification['inherent_impact_scale'] = $identification['inherent']['impact_scale_id'];
            $identification['inherent_impact_value'] = $identification['inherent']['impact_value'];
            $identification['inherent_risk_exposure'] = $identification['inherent']['risk_exposure'];
            $identification['inherent_risk_level'] = $identification['inherent']['risk_level'];
            $identification['inherent_risk_scale'] = $identification['inherent']['risk_scale'];

            $residuals = [];
            $worksheet->target->identification->residuals->each(function ($residual) use (&$residuals) {
                $residual = [
                    "residual[{$residual['quarter']}][impact_scale]" => $residual['impact_scale_id'],
                    "residual[{$residual['quarter']}][impact_probability]" => $residual['impact_probability_scale_id'],
                    "residual[{$residual['quarter']}][impact_value]" => $residual['impact_value'],
                    "residual[{$residual['quarter']}][impact_probability_scale]" => $residual['impact_probability_scale_id'],
                    "residual[{$residual['quarter']}][risk_exposure]" => $residual['risk_exposure'],
                    "residual[{$residual['quarter']}][risk_scale]" => $residual['risk_scale'],
                    "residual[{$residual['quarter']}][risk_level]" => $residual['risk_level'],
                ];

                $residuals[] = $residual;
            });

            $identification = array_merge($identification, ...$residuals);
            unset(
                $identification['created_at'],
                $identification['updated_at'],
                $identification['worksheet_target_id'],
                $identification['kbumn_target_id'],
                $identification['risk_category_t2'],
                $identification['risk_category_t3'],
                $identification['incidents'],
                $identification['inherent'],
                $identification['residuals'],
                $identification['risk_category_id'],
                $identification['risk_category_t2_id'],
                $identification['risk_category_t3_id'],
                $identification['existing_control_type_id'],
                $identification['control_effectiveness_assessment_id'],
            );

            $data = [
                'context' => [
                    'period_date' => $worksheet->created_at->format('M d, Y'),
                    'period_year' => $worksheet->created_at->format('Y'),
                    'risk_number' => $worksheet->worksheet_number,
                    'target_body' => $worksheet->target->body,
                    'unit_name' => $worksheet->unit_name,
                ],
                'strategies' => $worksheet->target->strategies->select([
                    'id',
                    'body',
                    'expected_feedback',
                    'risk_value',
                    'risk_value_limit',
                    'decision',
                ])->map(function ($strategy) {
                    return [
                        'id' => $strategy['id'],
                        'key' => $strategy['id'],
                        'strategy_body' => $strategy['body'],
                        'strategy_expected_feedback' => $strategy['expected_feedback'],
                        'strategy_risk_value' => $strategy['risk_value'],
                        'strategy_risk_value_limit' => $strategy['risk_value_limit'],
                        'strategy_decision' => $strategy['decision'],
                    ];
                }),
                'identification' => $identification,
                'incidents' => $worksheet->target->identification->incidents->select([
                    'id',
                    'risk_number',
                    'risk_chronology_body',
                    'risk_chronology_description',
                    'risk_cause_body',
                    'kri_body',
                    'kri_unit',
                    'kri_threshold_safe',
                    'kri_threshold_caution',
                    'kri_threshold_danger',
                    'risk_cause_number',
                    'risk_cause_code',
                ])->map(function ($incident) {
                    $incident['key'] = $incident['id'];
                    $incident['kri_unit'] = $incident['kri_unit']['id'];
                    return $incident;
                }),
                'mitigations' => $worksheet->target->identification->incidents->flatMap(function ($incident) {
                    return $incident->mitigations->map(function ($mitigation) use ($incident) {
                        return [
                            'id' => $mitigation['id'],
                            'key' => $mitigation['id'],
                            'risk_number' => explode('.', $incident['risk_cause_code'])[0],
                            'risk_cause_number' => $incident['risk_cause_number'],
                            'risk_treatment_option' => $mitigation['risk_treatment_option_id'],
                            'risk_treatment_type' => $mitigation['risk_treatment_type_id'],
                            'mitigation_rkap_program_type' => $mitigation['mitigation_rkap_program_type_id'],
                            'mitigation_plan' => $mitigation['mitigation_plan'],
                            'mitigation_output' => $mitigation['mitigation_output'],
                            'mitigation_cost' => $mitigation['mitigation_cost'],
                            'mitigation_start_date' => $mitigation['mitigation_start_date'],
                            'mitigation_end_date' => $mitigation['mitigation_end_date'],
                            'mitigation_pic' => $mitigation['mitigation_pic'],
                        ];
                    });
                }),
            ];

            return response()->json([
                'data' => $data,
                'load_time' => microtime(true) - $start
            ]);
        }

        $worksheet->target->identification->residuals = $worksheet->target->identification->residuals->select(
            'impact_value',
            'impact_scale',
            'impact_probability',
            'impact_probability_scale',
            'risk_exposure',
            'risk_scale',
            'risk_level'
        )->map(function ($item) {
            return [
                $item['impact_value'],
                $item['impact_scale']['scale'],
                $item['impact_probability'],
                $item['impact_probability_scale']['impact_probability'],
                $item['risk_exposure'],
                $item['risk_scale'],
                $item['risk_level'],
            ];
        });

        $title = 'Detail Kertas Kerja';
        return view('risk.assessment.worksheet.index', compact('worksheet', 'title'));
    }

    public function edit(string $worksheet)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheet);

        $start = microtime(true);
        $worksheet->load([
            'target',
            'target.identification',
            'target.identification.kbumn_target',
            'target.identification.risk_category_t2',
            'target.identification.risk_category_t3',
            'target.identification.incidents',
            'target.identification.incidents.kri_unit',
            'target.identification.incidents.mitigations',
            'target.identification.incidents.mitigations.risk_treatment_option',
            'target.identification.incidents.mitigations.risk_treatment_type',
            'target.identification.incidents.mitigations.rkap_program_type',

            'target.identification.inherent',
            'target.identification.residuals',
            'target.identification.residuals.impact_scale',
            'target.identification.residuals.impact_probability_scale',
            'target.identification.incidents.mitigations',
            'target.identification.existing_control_type',
            'target.identification.control_effectiveness_assessment',
            'target.strategies',
            'last_history.user',
        ]);

        $worksheet->target->identification->residuals = $worksheet->target->identification->residuals->select(
            'impact_value',
            'impact_scale',
            'impact_probability',
            'impact_probability_scale',
            'risk_exposure',
            'risk_scale',
            'risk_level'
        )->map(function ($item) {
            return [
                $item['impact_value'],
                $item['impact_scale']['scale'],
                $item['impact_probability'],
                $item['impact_probability_scale']['impact_probability'],
                $item['risk_exposure'],
                $item['risk_scale'],
                $item['risk_level'],
            ];
        });

        $worksheet_number = $worksheet->worksheet_number;
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

        $title = 'Form Edit Kertas Kerja';
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
            'risk_treatment_options',
            'worksheet'
        ));
    }

    public function update(string $worksheetId, Request $request)
    {
        try {
            $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);

            DB::beginTransaction();
            $user = auth()->user();
            $worksheet->target()->delete();

            $target = $worksheet->target()->create([
                'body' => $request->context['target_body']
            ]);

            $strategies = [];
            foreach ($request->strategies as $index => $items) {
                $strategy = [];
                foreach ($items as $key => $value) {
                    $strategy[str_replace('strategy_', '', $key)] = $value;
                }

                $strategies[] = $strategy;
            }
            $strategies = $target->strategies()->createMany($strategies);

            $identification = ['created_by' => $user->employee_id];
            foreach ($request->identification as $key => $value) {
                if (str_contains($key, 'inherent') || str_contains($key, 'residual')) {
                    continue;
                }

                if (in_array($key, ['existing_control_type', 'kbumn_target', 'control_effectiveness_assessment'])) {
                    $identification[$key . '_id'] = $value == 'Pilih' || !$value ? null : $value;
                } else if (str_contains($key, 'risk_category')) {
                    $identification[str_replace('kbumn_', '', $key) . '_id'] = $value == 'Pilih' || !$value ? null : $value;
                } else {
                    if ($key == 'key' || ($key == 'id' && !$value)) {
                        continue;
                    }

                    $identification[$key] = $value == 'Pilih' || !$value ? null : $value;
                }
            }

            $inherent = [];
            $residuals = [];
            foreach ($request->identification as $key => $value) {
                $residual = [];
                if (str_contains($key, 'inherent')) {
                    $key = str_replace('inherent_', '', $key);
                    $key .= in_array($key, ['impact_probability_scale', 'impact_scale']) ? '_id' : '';

                    $inherent[$key] = $value == 'Pilih' || !$value ? null : $value;
                } else if (str_contains($key, 'residual')) {
                    foreach ($value as $quarter => $residual) {
                        if ($residual) {
                            $residual['quarter'] = $quarter;
                            foreach ($residual as $residualKey => $residualValue) {
                                $residualKey .= in_array($residualKey, ['impact_probability_scale', 'impact_scale']) ? '_id' : '';
                                $residual[$residualKey] = $residualValue;
                            }
                            $residuals[] = $residual;
                        }
                    }
                }
            }
            $identification = $target->identification()->create($identification);
            $inherent = $identification->inherent()->create($inherent);
            $residuals = $identification->residuals()->createMany($residuals);

            $incidents = [];
            foreach ($request->incidents as $index => $item) {
                $incident = [];
                foreach ($item as $key => $value) {
                    if ($key == 'key') continue;

                    $key = $key == 'kri_unit' ? $key . '_id' : $key;
                    $incident[$key] = $value;
                }

                $incidents[] = $incident;
            }

            $incidents = $identification->incidents()->createMany($incidents);

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

            $worksheet->last_history()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk admin',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => DocumentStatus::DRAFT->value,
                'note' => 'Memperbarui kertas kerja'
            ]);

            DB::commit();
            return response()->json(['data' => [
                'id' => $worksheetId
            ]]);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update_status(string $worksheetId, Request $request)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $currentRole = session()->get('current_role');

        $rule = Str::snake($currentRole->name) . '_rule';

        try {
            DB::beginTransaction();
            $this->$rule($worksheet, $request->status, $request->note);
            DB::commit();

            flash_message('flash_message', 'Status berhasil diperbarui', State::SUCCESS);
            return redirect()->route('risk.assessment.worksheet.show', $worksheetId);
        } catch (Exception $e) {
            DB::rollBack();
            flash_message('flash_message', $e->getMessage(), State::ERROR);
            return redirect()->route('risk.assessment.worksheet.show', $worksheetId);
        }
    }

    protected function risk_admin_rule(Worksheet $worksheet, string $status, string $note): WorksheetHistory
    {
        $worksheet->update(['status' => DocumentStatus::ON_REVIEW->value]);
        return $worksheet->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk admin',
            'receiver_id' => 3,
            'receiver_role' => 'risk owner',
            'status' => DocumentStatus::ON_REVIEW->value,
            'note' => $note
        ]);
    }

    protected function risk_owner_rule(Worksheet $worksheet, string $status, string $note): WorksheetHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::DRAFT) {
            $worksheet->update(['status' => $status->value]);
            return $worksheet->histories()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk owner',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => $status->value,
                'note' => $note
            ]);
        }

        $worksheet->update(['status' => DocumentStatus::ON_CONFIRMATION->value]);
        return $worksheet->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk owner',
            'receiver_id' => 4,
            'receiver_role' => 'risk otorisator',
            'status' => DocumentStatus::ON_CONFIRMATION->value,
            'note' => $note
        ]);
    }

    protected function risk_otorisator_rule(Worksheet $worksheet, string $status, string $note): WorksheetHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::ON_REVIEW) {
            $worksheet->update(['status' => $status->value]);
            return $worksheet->histories()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk otorisator',
                'receiver_id' => 3,
                'receiver_role' => 'risk owner',
                'status' => $status->value,
                'note' => $note
            ]);
        }

        $worksheet->update(['status' => DocumentStatus::APPROVED->value]);
        return $worksheet->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk otorisator',
            'receiver_id' => 2,
            'receiver_role' => 'risk admin',
            'status' => DocumentStatus::APPROVED->value,
            'note' => $note
        ]);
    }
}
