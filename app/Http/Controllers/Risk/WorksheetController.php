<?php

namespace App\Http\Controllers\Risk;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\Master\ControlEffectivenessAssessment;
use App\Models\Master\ExistingControlType;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\KRIThreshold;
use App\Models\Master\KRIUnit;
use App\Models\Master\Position;
use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentType;
use App\Models\Master\RKAPProgramType;
use App\Models\RBAC\Role;
use App\Models\Risk\MonitoringResidual;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetHistory;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetMitigation;
use App\Services\PositionService;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WorksheetController extends Controller
{
    public function __construct(
        private RoleService $roleService,
        private PositionService $positionService
    ) {}

    public function index()
    {
        $title = 'Form Kertas Kerja';

        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $existing_control_types = ExistingControlType::all();
        $kri_thresholds = KRIThreshold::all();
        $kri_units = KRIUnit::all();
        $control_effectiveness_assessments = ControlEffectivenessAssessment::all();
        $rkap_program_types = RKAPProgramType::with('children')->parentOnly()->get();
        $risk_treatment_types = RiskTreatmentType::all();
        $risk_treatment_options = RiskTreatmentOption::all();

        return view('risk.worksheet.index', compact(
            'title',
            'kbumn_risk_categories',
            'existing_control_types',
            'kri_thresholds',
            'kri_units',
            'control_effectiveness_assessments',
            'rkap_program_types',
            'risk_treatment_types',
            'risk_treatment_options'
        ));
    }

    public function create()
    {
        return view('risk.worksheet.index');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $worksheet = Worksheet::create([
                'worksheet_code' =>  'WR/' . date('Y') . '/' . Str::random(8),
                'worksheet_number' => $request->context['risk_number'],
                'company_code' => 'API',
                'company_name' => 'PT Angkasa Pura Indonesia',
                'target_body' => $request->context['target_body'],
                'status' => DocumentStatus::DRAFT->value,
                'created_by' => $user->employee_id,
            ] + $user->only('organization_name', 'organization_code', 'unit_name', 'unit_code', 'sub_unit_name', 'sub_unit_code', 'personnel_area_name', 'personnel_area_code'));

            $strategies = [];
            foreach ($request->strategies as $index => $items) {
                $strategy = [];
                foreach ($items as $key => $value) {
                    $strategy[str_replace('strategy_', '', $key)] = $value;
                }

                $strategies[] = $strategy;
            }
            $worksheet->strategies()->createMany($strategies);

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

                    $identification[$key] = $value == 'Pilih' || !$value ? '' : $value;
                }
            }

            foreach ($request->identification as $key => $value) {
                if (str_contains($key, 'inherent')) {
                    if (
                        str_contains($key, 'impact_probability_scale') ||
                        str_contains($key, 'impact_scale')
                    ) {
                        $key .= '_id';
                        $identification[$key] = $value == 'Pilih' || !$value ? null : $value;
                    } else {
                        $identification[$key] = $value == 'Pilih' || !$value ? '' : $value;
                    }
                } else if (str_contains($key, 'residual')) {
                    foreach ($value as $quarter => $residual) {
                        if ($residual) {
                            foreach ($residual as $residualKey => $residualValue) {
                                $residualKey .= in_array($residualKey, ['impact_probability_scale', 'impact_scale']) ? '_id' : '';
                                $identification['residual_' . $quarter . '_' . $residualKey] = $residualValue == 'Pilih' || !$residualValue ? '' : $residualValue;
                            }
                        }
                    }
                }
            }
            $identification = $worksheet->identification()->create($identification);

            $incidents = [];
            foreach ($request->incidents as $item) {
                $incident = [];
                foreach ($item as $key => $value) {
                    if ($key == 'key') continue;

                    $key = $key == 'kri_unit' ? $key . '_id' : $key;
                    $incident[$key] = $value;
                }

                $incidents[] = $incident;
            }

            $incidents = $worksheet->incidents()->createMany($incidents);

            $mitigations = [];
            $incidents_array = $incidents->toArray();
            foreach ($request->mitigations as $item) {
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

                    if ($value == 'Pilih') {
                        $mitigation[$key] = null;
                    } else {
                        $mitigation[$key] = $key == 'mitigation_cost' ? ($value ?: '0') : $value;
                    }
                }

                $mitigations[] = $incidents[$incidentIndex]->mitigations()->create($mitigation);
            }

            $role = session()->get('current_role') ?? $user->roles()->first();
            $history = [
                'created_by' => $user->employee_id,
                'created_role' => $role->name,
                'status' => DocumentStatus::DRAFT->value,
                'note' => 'Membuat kertas kerja baru'
            ];

            if ($role->name == 'risk admin') {
                $history = array_merge($history, [
                    'receiver_id' => 3,
                    'receiver_role' => 'risk owner',
                ]);
            } else {
                $history = array_merge($history, [
                    'receiver_id' => $role->id,
                    'receiver_role' => $role->name,
                ]);
            }

            $worksheet->last_history()->create($history);
            DB::commit();
            return response()->json([
                'message' => 'Kertas kerja berhasil dibuat',
                'data' => [
                    'redirect' => route('risk.worksheet.show', $worksheet->getEncryptedId())
                ]
            ])->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500)->header('Cache-Control', 'no-store');
        }
    }

    public function show(string $worksheet)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheet);

        if (
            session()->get('current_role')?->name == 'risk admin' &&
            $worksheet->created_by != auth()->user()->employee_id
        ) {
            abort(404, 'Data tidak ditemukan');
        }

        $worksheet->identification = WorksheetIdentification::identificationQuery()->whereWorksheetId($worksheet->id)->firstOrFail();
        $worksheet->load('strategies', 'incidents.mitigations');

        if (request()->ajax()) {
            $identification = (array) $worksheet->identification;
            $identification['id'] = $identification['id'];
            $identification['kbumn_risk_category_t2'] = $identification['risk_category_t2_id'];
            $identification['kbumn_risk_category_t3'] = $identification['risk_category_t3_id'];
            $identification['existing_control_type'] = $identification['existing_control_type_id'];
            $identification['control_effectiveness_assessment'] = $identification['control_effectiveness_assessment_id'];

            $identification['inherent_body'] = $identification['inherent_body'];
            $identification['inherent_impact_probability'] = $identification['inherent_impact_probability'];
            $identification['inherent_impact_probability_scale'] = $identification['inherent_impact_probability_scale_id'];
            $identification['inherent_impact_scale'] = $identification['inherent_impact_scale_id'];
            $identification['inherent_impact_value'] = $identification['inherent_impact_value'];
            $identification['inherent_risk_exposure'] = $identification['inherent_risk_exposure'];
            $identification['inherent_risk_level'] = $identification['inherent_risk_level'];
            $identification['inherent_risk_scale'] = $identification['inherent_risk_scale'];

            $residuals = [];
            for ($quarter = 1; $quarter <= 4; $quarter++) {
                $residual = [
                    "residual[$quarter][impact_scale]" => $identification["residual_{$quarter}_impact_scale_id"],
                    "residual[$quarter][impact_probability]" => $identification["residual_{$quarter}_impact_probability"],
                    "residual[$quarter][impact_value]" => $identification["residual_{$quarter}_impact_value"],
                    "residual[$quarter][impact_probability_scale]" => $identification["residual_{$quarter}_impact_probability_scale_id"],
                    "residual[$quarter][risk_exposure]" => $identification["residual_{$quarter}_risk_exposure"],
                    "residual[$quarter][risk_scale]" => $identification["residual_{$quarter}_risk_scale"],
                    "residual[$quarter][risk_level]" => $identification["residual_{$quarter}_risk_level"],
                ];

                unset(
                    $identification["residual_{$quarter}_impact_scale"],
                    $identification["residual_{$quarter}_impact_scale_id"],
                    $identification["residual_{$quarter}_impact_probability"],
                    $identification["residual_{$quarter}_impact_value"],
                    $identification["residual_{$quarter}_impact_probability_scale"],
                    $identification["residual_{$quarter}_impact_probability_scale_id"],
                    $identification["residual_{$quarter}_risk_exposure"],
                    $identification["residual_{$quarter}_risk_scale"],
                    $identification["residual_{$quarter}_risk_level"],
                );

                $residuals[] = $residual;
            }

            $identification = array_merge($identification, ...$residuals);
            unset(
                $identification['worksheet_id'],
                $identification['created_at'],
                $identification['updated_at'],
                $identification['risk_category_t2_name'],
                $identification['risk_category_t3_name'],
                $identification['risk_category_t2_id'],
                $identification['risk_category_t3_id'],
                $identification['existing_control_type_id'],
                $identification['existing_control_type_name'],
                $identification['control_effectiveness_assessment_id'],
                $identification['control_effectiveness_assessment_name'],
                $identification['inherent_impact_scale_id'],
                $identification['inherent_impact_probability_scale_id'],
            );

            $data = [
                'context' => [
                    'period_date' => $worksheet->created_at->format('M d, Y'),
                    'period_year' => $worksheet->created_at->format('Y'),
                    'risk_number' => $worksheet->worksheet_number,
                    'target_body' => $worksheet->target_body,
                    'unit_name' => $worksheet->unit_name,
                ],
                'strategies' => $worksheet->strategies->select([
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
                'incidents' => $worksheet->incidents->select([
                    'id',
                    'risk_number',
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
                'mitigations' => $worksheet->incidents->flatMap(function ($incident) {
                    return $incident->mitigations->map(function ($mitigation) use ($incident) {
                        return [
                            'id' => $mitigation['id'],
                            'key' => $mitigation['id'],
                            'incident_id' => $incident->id,
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
                            'organization_code' => $mitigation['organization_code'],
                            'organization_name' => $mitigation['organization_name'],
                            'unit_code' => $mitigation['unit_code'],
                            'unit_name' => $mitigation['unit_name'],
                            'sub_unit_code' => $mitigation['sub_unit_code'],
                            'sub_unit_name' => $mitigation['sub_unit_name'],
                            'personnel_area_code' => $mitigation['personnel_area_code'],
                            'personnel_area_name' => $mitigation['personnel_area_name'],
                            'position_name' => $mitigation['position_name'],
                        ];
                    });
                }),
            ];

            return response()->json([
                'data' => $data,
                'message' => 'success'
            ])->header('Cache-Control', 'no-store');
        }

        $title = 'Detail Kertas Kerja';
        return view('risk.worksheet.index', compact('worksheet', 'title'));
    }

    public function edit(string $worksheet)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheet);
        if (
            session()->get('current_role')?->name == 'risk admin' &&
            $worksheet->created_by != auth()->user()->employee_id
        ) {
            abort(404, 'Data tidak ditemukan');
        }
        $worksheet->identification = WorksheetIdentification::identificationQuery()->first();
        $worksheet->load('incidents.mitigations');

        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $existing_control_types = ExistingControlType::all();
        $kri_thresholds = KRIThreshold::all();
        $kri_units = KRIUnit::all();
        $control_effectiveness_assessments = ControlEffectivenessAssessment::all();
        $rkap_program_types = RKAPProgramType::with('children')->parentOnly()->get();
        $risk_treatment_types = RiskTreatmentType::all();
        $risk_treatment_options = RiskTreatmentOption::all();

        $title = 'Form Edit Kertas Kerja';
        return view('risk.worksheet.index', compact(
            'title',
            'kbumn_risk_categories',
            'existing_control_types',
            'kri_thresholds',
            'kri_units',
            'control_effectiveness_assessments',
            'rkap_program_types',
            'risk_treatment_types',
            'risk_treatment_options',
            'worksheet'
        ));
    }

    public function update(string $worksheetId, Request $request)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        if (
            session()->get('current_role')?->name == 'risk admin' &&
            $worksheet->created_by != auth()->user()->employee_id
        ) {
            abort(ResponseStatus::HTTP_NOT_FOUND, 'Data tidak ditemukan');
        }

        $hasAlreadyApproved = $worksheet->histories()->where('status', DocumentStatus::APPROVED->value)->exists();
        try {
            DB::beginTransaction();
            $worksheet->update([
                'worksheet_number' => $request->context['risk_number'],
                'taget_body' => $request->context['target_body'],
            ]);

            $strategies = [];
            $strategyIds = [];
            foreach ($request->strategies as $index => $items) {
                $strategy = [];
                foreach ($items as $key => $value) {
                    if ($key == 'key') continue;
                    $strategy[str_replace('strategy_', '', $key)] = $value;
                }

                if ($items['id']) {
                    $strategyIds[] = $items['id'];
                    unset($strategy['id']);
                    throw_if(
                        !$worksheet->strategies()->where('id', $items['id'])->update($strategy),
                        new Exception("Failed to update strategy data with ID {$worksheet->id}: {$items['id']}", ResponseStatus::HTTP_BAD_REQUEST)
                    );
                } else {
                    $strategies[] = $strategy;
                }
            }

            if ($strategies) {
                $strategies = $worksheet->strategies()->createMany($strategies)->pluck('id')->toArray();
                throw_if(!$strategies, new Exception("Failed to create new strategy data with Worksheet ID {$worksheet->id}", ResponseStatus::HTTP_BAD_REQUEST));

                $strategyIds = array_unique(array_merge($strategyIds, $strategies));
            }

            if ($strategyIds) {
                $worksheet->strategies()->whereNotIn('id', array_unique($strategyIds))->delete();
                logger()->info("[Worksheet] Attempt to delete strategy data with Worksheet ID {$worksheet->id} Not In " . implode(',', array_unique($strategyIds)));
            }

            $identification = [];
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

                    $identification[$key] = $value == 'Pilih' || !$value ? '' : $value;
                }
            }

            foreach ($request->identification as $key => $value) {
                if (str_contains($key, 'inherent')) {
                    if (
                        str_contains($key, 'impact_probability_scale') ||
                        str_contains($key, 'impact_scale')
                    ) {
                        $key .= '_id';
                        $identification[$key] = $value == 'Pilih' || !$value ? null : $value;
                    } else {
                        $identification[$key] = $value == 'Pilih' || !$value ? '' : $value;
                    }
                } else if (str_contains($key, 'residual')) {
                    foreach ($value as $quarter => $item) {
                        if ($item) {
                            foreach ($item as $residualKey => $residualValue) {
                                $residualKey .= in_array($residualKey, ['impact_probability_scale', 'impact_scale']) ? '_id' : '';
                                $identification['residual_' . $quarter . '_' . $residualKey] = $residualValue == 'Pilih' || !$residualValue ? '' : $residualValue;
                            }
                        }
                    }
                }
            }

            unset($identification['target_body']);
            throw_if(!$worksheet->identification()->update($identification), new Exception("Failed to update identification data with Worksheet ID {$worksheet->id}: {$worksheet->identification->id}", ResponseStatus::HTTP_BAD_REQUEST));

            $incidents = [];
            $incident_ids = [];
            $new_incidents = [];
            foreach ($request->incidents as $index => $item) {
                $incident = [];
                foreach ($item as $key => $value) {
                    if (in_array($key, ['key', 'risk_number'])) continue;

                    $key = $key == 'kri_unit' ? $key . '_id' : $key;
                    $incident[$key] = $value;
                }

                if ($incident['id']) {
                    $incident_ids[] = $incident['id'];
                    throw_if(
                        !$worksheet->incidents()->where('id', $incident['id'])->update($incident),
                        new Exception("Failed to update incident data with Worksheet ID {$worksheet->id}: {$incident['id']}", ResponseStatus::HTTP_BAD_REQUEST)
                    );
                    $incidents[] = $incident;
                } else {
                    $new_incidents[] = $incident;
                }
            }

            if ($new_incidents) {
                $new_incidents = $worksheet->incidents()->createMany($new_incidents);
                throw_if(
                    empty($new_incidents->toArray()),
                    new Exception("Failed to create new incidents with Worksheet ID {$worksheet->id}", ResponseStatus::HTTP_BAD_REQUEST)
                );


                $incident_ids = array_unique(array_merge($incident_ids, $new_incidents->pluck('id')->toArray()));
            }

            if ($incident_ids) {
                $worksheet->incidents()->whereNotIn('id', $incident_ids)->delete();
                logger()->info("[Worksheet] Attempt to delete incident data with Worksheet ID {$worksheet->id} Not In ID " . implode(',', $incident_ids));
            }


            $incidents_array = array_merge($incidents, $new_incidents ? $new_incidents->toArray() : []);
            $new_mitigations = [];
            $mitigation_ids = [];
            foreach ($request->mitigations as $index => $item) {
                $incidentIndex = array_search(
                    $item['risk_cause_number'],
                    array_column($incidents_array, 'risk_cause_number')
                );

                if ($incidentIndex === false) {
                    continue;
                }

                $mitigation = [
                    'worksheet_incident_id' => $item['incident_id'] ?? null
                ];

                foreach ($item as $key => $value) {
                    if (in_array($key, ['incident_id', 'key']) || str_contains($key, '_number')) continue;
                    $key =
                        $key == 'risk_treatment_option' ||
                        $key == 'risk_treatment_type' ||
                        $key == 'mitigation_rkap_program_type'
                        ? $key . '_id' : $key;

                    if ($value == 'Pilih') {
                        $mitigation[$key] = null;
                    } else {
                        $mitigation[$key] = $key == 'mitigation_cost' ? ($value ?: '0') : $value;
                    }
                }

                $mitigation_id = $mitigation['id'];
                unset($mitigation['id']);

                if (
                    $mitigation_id && $mitigation['worksheet_incident_id'] == $incidents_array[$incidentIndex]['id']
                ) {
                    $mitigation_ids[] = $mitigation_id;
                    throw_if(
                        !WorksheetMitigation::where('id', $mitigation_id)->update($mitigation),
                        new Exception("Failed to update mitigation data from Worksheet ID {$worksheet->id}: {$mitigation_id}", ResponseStatus::HTTP_BAD_REQUEST)
                    );
                } else {
                    $mitigation['worksheet_incident_id'] = $incidents_array[$incidentIndex]['id'];
                    $mitigation['created_at'] = now();
                    $mitigation['updated_at'] = now();
                    $new_mitigations[] = $mitigation;
                }
            }

            if ($mitigation_ids) {
                $mitigation_ids = array_unique($mitigation_ids);
                WorksheetMitigation::whereIn('worksheet_incident_id', $incident_ids)->whereNotIn('id', $mitigation_ids)->delete();
                logger()->info("[Worksheet] Failed to delete mitigation data from Worksheet ID {$worksheet->id} Not In ID " . implode(',', $mitigation_ids));
            }

            if ($new_mitigations) {
                throw_if(
                    !WorksheetMitigation::insert($new_mitigations),
                    new Exception("Failed to create mitigations from Worksheet ID {$worksheet->id}", ResponseStatus::HTTP_BAD_REQUEST)
                );
            }

            $role = session()->get('current_role') ?? auth()->user()->roles()->first();
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => $role->name,
                'status' => $worksheet->status,
                'note' => 'Memperbarui kertas kerja'
            ];

            if ($role->name == 'risk admin') {
                $history = array_merge($history, [
                    'receiver_id' => 3,
                    'receiver_role' => 'risk owner',
                ]);
            } else {
                $history = array_merge($history, [
                    'receiver_id' => $role->id,
                    'receiver_role' => $role->name,
                ]);
            }

            if ($hasAlreadyApproved) {
                $history['status'] = DocumentStatus::APPROVED->value;
                $worksheet->update(['status' => DocumentStatus::APPROVED->value]);
            }

            $worksheet->last_history()->create($history);

            DB::commit();
            flash_message('flash_message', 'Kertas kerja berhasil diperbarui', State::SUCCESS);
            return response()->json([
                'message' => 'Kertas kerja berhasil diperbarui',
                'data' => [
                    'redirect' => route('risk.worksheet.show', $worksheet->getEncryptedId())
                ]
            ])->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Worksheet] ' . $e->getMessage(), [$e]);
            flash_message('flash_message', 'Gagal memperbarui kertas kerja', State::ERROR);
            return response()
                ->json(['message' => 'Gagal memperbarui kertas kerja'], $e->getCode() ?: ResponseStatus::HTTP_INTERNAL_SERVER_ERROR)
                ->header('Cache-Control', 'no-store');
        }
    }

    public function destroy(string $worksheetId)
    {
        try {
            $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
            if (
                session()->get('current_role')?->name == 'risk admin' &&
                $worksheet->created_by != auth()->user()->employee_id
            ) {
                abort(404, 'Data tidak ditemukan');
            }

            if (!in_array($worksheet->status, [DocumentStatus::DRAFT->value, DocumentStatus::ON_REVIEW->value])) {
                throw_if(
                    !$worksheet->delete(),
                    new Exception("Failed to delete worksheet with ID {$worksheet->id}, document is on progress")
                );
            }

            DB::beginTransaction();
            throw_if(!$worksheet->delete(), new Exception("Failed to delete worksheet with ID {$worksheet->id}"));
            DB::commit();

            flash_message('flash_message', 'Kertas kerja berhasil dihapus', State::SUCCESS);
            return redirect()->route('risk.assessment.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Worksheet] ' . $e->getMessage());

            flash_message('flash_message', 'Gagal menghapus kertas kerja', State::ERROR);
            return redirect()->back();
        }
    }

    public function update_status(string $worksheetId, Request $request)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $currentRole = session()->get('current_role');

        if (
            $currentRole?->name == 'risk admin' &&
            $worksheet->created_by != auth()->user()->employee_id
        ) {
            abort(404, 'Data tidak ditemukan');
        }

        try {
            $rule = Str::snake($currentRole->name == 'risk analis' ? $request->role : $currentRole->name) . '_rule';
            if (!method_exists($this, $rule)) {
                throw new Exception("Target role not found: {$rule}");
            }
            DB::beginTransaction();
            $this->$rule($worksheet, $request->status, $request->note);
            DB::commit();

            flash_message('flash_message', 'Status Kertas Kerja berhasil diperbarui', State::SUCCESS);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error("[Worksheet] Failed to update status of worksheet with ID {$worksheet->id}: " . $e->getMessage(), [$e]);
            flash_message('flash_message', 'Status Kertas Kerja gagal diperbarui', State::ERROR);
        }
        return redirect()->route('risk.worksheet.show', $worksheetId);
    }

    protected function risk_admin_rule(Worksheet $worksheet, string $status, ?string $note = ''): WorksheetHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status != DocumentStatus::ON_REVIEW) {
            $status = $status instanceof DocumentStatus ? $status->value : $status;
            throw new Exception("Attempt to update worksheet with ID {$worksheet->id} status from {$worksheet->status} to " . ($status ?? '')  . ' as Risk Admin');
        }

        $worksheet->update(['status' => DocumentStatus::ON_REVIEW->value]);
        return $worksheet->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk admin',
            'receiver_id' => 3,
            'receiver_role' => 'risk owner',
            'status' => $status->value,
            'note' => $note
        ]);
    }

    protected function risk_owner_rule(Worksheet $worksheet, string $status, ?string $note = ''): WorksheetHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::REVISED) {
            $status = DocumentStatus::DRAFT;
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk owner',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => $status->value,
                'note' => $note
            ];
        } else if ($status == DocumentStatus::ON_REVIEW) {
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk owner',
                'receiver_id' => 3,
                'receiver_role' => 'risk owner',
                'status' => $status->value,
                'note' => $note
            ];
        } else if ($status == DocumentStatus::ON_CONFIRMATION) {
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk owner',
                'receiver_id' => 4,
                'receiver_role' => 'risk otorisator',
                'status' => $status->value,
                'note' => $note
            ];
        } else {
            $status = $status instanceof DocumentStatus ? $status->value : $status;
            throw new Exception("Attempt to update worksheet with ID {$worksheet->id} status from {$worksheet->status} to " . ($status ?? '')  . ' as Risk Owner');
        }

        $worksheet->update(['status' => $status->value]);

        return $worksheet->histories()->create($history);
    }

    protected function risk_otorisator_rule(Worksheet $worksheet, string $status, ?string $note = ''): WorksheetHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::ON_REVIEW || $status == DocumentStatus::REVISED) {
            $status = DocumentStatus::ON_REVIEW;
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk otorisator',
                'receiver_id' => 3,
                'receiver_role' => 'risk owner',
                'status' => $status->value,
                'note' => $note
            ];
        } else if ($status == DocumentStatus::APPROVED) {
            $role = $worksheet->creator?->roles()?->first();
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk otorisator',
                'receiver_id' => $role?->id ?? 'risk admin',
                'receiver_role' => $role?->name ?? 'risk admin',
                'status' => $status->value,
                'note' => $note
            ];
        } else {
            $status = $status instanceof DocumentStatus ? $status->value : $status;
            throw new Exception("Attempt to update worksheet with ID {$worksheet->id} status from {$worksheet->status} to " . ($status ?? '')  . ' as Risk Otorisator');
        }

        $worksheet->update(['status' => $status->value]);
        return $worksheet->histories()->create($history);
    }

    public function get_by_inherent_risk_scale(int $riskScale)
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }

        $worksheets = Worksheet::assessmentQuery()
            ->when(
                !$this->roleService->isRiskAdmin(),
                fn($q) => $q->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                    )
                )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            )
            ->when(
                $this->roleService->isRiskAdmin(),
                fn($q) => $q->where('w.created_by', auth()->user()->employee_id)
                    ->where('w.sub_unit_code', $unit?->sub_unit_code ?? '')
            )
            ->where('h_i.risk_scale', $riskScale)
            ->whereYear('w.created_at', request('year', date('Y')));

        return DataTables::of($worksheets)
            ->editColumn('worksheet_id', function ($worksheet) {
                return route('risk.worksheet.show', Crypt::encryptString((string) $worksheet->worksheet_id));
            })
            ->orderColumn('created_at', 'w.created_at $1')
            ->make(true);
    }

    public function get_by_target_risk_scale(int $riskScale)
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }

        $quarter = request('quarter', 1);
        $quarter = in_array($quarter, [1, 2, 3, 4]) ? $quarter : 1;

        $worksheets = Worksheet::residualMapQuery($quarter)
            ->when(
                !$this->roleService->isRiskAdmin(),
                fn($q) => $q->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                    )
                )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            )
            ->when(
                $this->roleService->isRiskAdmin(),
                fn($q) => $q->where('w.created_by', auth()->user()->employee_id)
                    ->where('w.sub_unit_code', $unit?->sub_unit_code ?? '')
            )
            ->where("h_r{$quarter}.risk_scale", $riskScale)
            ->whereYear('w.created_at', request('year', date('Y')));

        return DataTables::of($worksheets)
            ->editColumn('worksheet_id', function ($worksheet) {
                return route('risk.worksheet.show', Crypt::encryptString((string) $worksheet->worksheet_id));
            })
            ->orderColumn('created_at', 'w.created_at $1')
            ->make(true);
    }

    public function get_by_actualization_risk_scale(int $riskScale)
    {
        $unit = $this->roleService->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
            ) ?: $unit;
        }

        $worksheets = Worksheet::latestMonitoringWithMitigationQuery()
            ->when(
                !$this->roleService->isRiskAdmin(),
                fn($q) => $q->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        $this->roleService->isRiskOwner() || $this->roleService->isRiskAdmin()
                    )
                )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            )
            ->when(
                $this->roleService->isRiskAdmin(),
                fn($q) => $q->where('w.created_by', auth()->user()->employee_id)
                    ->where('w.sub_unit_code', $unit?->sub_unit_code ?? '-')
            )
            ->when(request('document_status'), fn($q) => $q->where('w.status_monitoring', request('document_status')))
            ->where('worksheet_year', request('year', date('Y')))
            ->where('hr.risk_scale', $riskScale)
            ->groupBy('lm.id');

        return DataTables::query($worksheets)
            ->editColumn('worksheet_id', function ($worksheet) {
                return route('risk.worksheet.show', Crypt::encryptString((string) $worksheet->worksheet_id));
            })
            ->orderColumn('period_date', 'lm.period_date $1')
            ->make(true);
    }
}
