<?php

namespace App\Http\Controllers\Risk;

use App\DTO\Worksheet\WorksheetRequestDTO;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\Risk\StoreWorksheetRequest;
use App\Http\Requests\Risk\UpdateWorksheetRequest;
use App\Models\Master\BUMNScale;
use App\Models\Master\ControlEffectivenessAssessment;
use App\Models\Master\ExistingControlType;
use App\Models\Master\Heatmap;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\KRIThreshold;
use App\Models\Master\KRIUnit;
use App\Models\Master\Position;
use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentType;
use App\Models\Master\RKAPProgramType;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetHistory;
use App\Models\Risk\WorksheetIdentification;
use App\Services\PositionService;
use App\Services\RoleService;
use App\Services\Worksheet\WorksheetService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WorksheetController extends Controller
{
    public function __construct(
        private PositionService $positionService,
        private WorksheetService $worksheetService
    ) {
        $this->worksheetService = new WorksheetService();
    }

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

    public function store(StoreWorksheetRequest $request)
    {
        $validated = $request->validated();

        $data['context'] = [
            'worksheet_number' => strip_tags(purify($validated['context']['risk_number'])),
            'risk_qualification' => strip_tags(purify($validated['context']['risk_qualification'])),
            'company_code' => 'API',
            'company_name' => 'PT Angkasa Pura Indonesia',
            'status' => DocumentStatus::DRAFT->value,
            'status_monitoring' => DocumentStatus::ON_MONITORING->value,
            'created_by' => auth()->user()->employee_id,
            'target_body' => purify($validated['context']['target_body']),
            'risk_number' => strip_tags(purify($validated['context']['risk_number'])),
        ] + role()->getCurrentUnit()->only([
            'unit_code',
            'unit_name',
            'sub_unit_code',
            'sub_unit_name',
            'organization_code',
            'organization_name',
            'personnel_area_code',
            'personnel_area_name',
        ]);

        $data['strategies'] = array_map(function ($strategy) {
            return [
                'body' => purify($strategy['strategy_body'] ?? ''),
                'expected_feedback' => purify($strategy['strategy_expected_feedback'] ?? ''),
                'risk_value' => purify($strategy['strategy_risk_value'] ?? ''),
                'risk_value_limit' => $strategy['strategy_risk_value_limit'],
                'decision' => $strategy['strategy_decision'],
            ];
        }, $validated['strategies'] ?? []);

        $data['identification'] = [
            'company_code' => 'API',
            'company_name' => 'PT Angkasa Pura Indonesia',
            'risk_category_t2_id' => $validated['identification']['risk_category_t2'],
            'risk_category_t3_id' => $validated['identification']['risk_category_t3'],
            'risk_chronology_body' => purify($validated['identification']['risk_chronology_body'] ?? ''),
            'risk_chronology_description' => purify($validated['identification']['risk_chronology_description'] ?? ''),
            'existing_control_type_id' => $validated['identification']['existing_control_type'],
            'existing_control_body' => purify($validated['identification']['existing_control_body'] ?? ''),
            'control_effectiveness_assessment_id' => $validated['identification']['control_effectiveness_assessment'],
            'risk_impact_category' => $validated['identification']['risk_impact_category'],
            'risk_impact_body' => purify($validated['identification']['risk_impact_body'] ?? ''),
            'risk_impact_start_date' => $validated['identification']['risk_impact_start_date'],
            'risk_impact_end_date' => $validated['identification']['risk_impact_end_date'],
            'inherent_body' => purify($validated['identification']['inherent_body'] ?? ''),
            'inherent_impact_value' => (float) $validated['identification']['inherent_impact_value'],
            'inherent_impact_scale_id' => $validated['identification']['inherent_impact_scale'],
            'inherent_impact_probability' => (int) $validated['identification']['inherent_impact_probability'],
            'inherent_impact_probability_scale_id' => $validated['identification']['inherent_impact_probability_scale'],
            'inherent_risk_exposure' => (float) $validated['identification']['inherent_risk_exposure'],
            'inherent_risk_level' => '',
            'inherent_risk_scale' => '',
        ];

        for ($i = 1; $i <= 4; $i++) {
            $data['identification']["residual_{$i}_impact_value"] = (float) $validated['identification']['residual'][$i]['impact_value'] ?? 0;
            $data['identification']["residual_{$i}_impact_scale_id"] = $validated['identification']['residual'][$i]['impact_scale'] ?? null;
            $data['identification']["residual_{$i}_impact_probability"] = (int) $validated['identification']['residual'][$i]['impact_probability'] ?? 0;
            $data['identification']["residual_{$i}_impact_probability_scale_id"] = $validated['identification']['residual'][$i]['impact_probability_scale'] ?? null;
            $data['identification']["residual_{$i}_risk_exposure"] = (float) $validated['identification']['residual'][$i]['risk_exposure'] ?? 0;
            $data['identification']["residual_{$i}_risk_level"] = '';
            $data['identification']["residual_{$i}_risk_scale"] = '';
        }

        $data['incidents'] = array_map(function ($incident) {
            return [
                'risk_cause_number' => strip_tags(purify($incident['risk_cause_number'] ?? '')),
                'risk_cause_code' => strip_tags(purify($incident['risk_cause_code'] ?? '')),
                'risk_cause_body' => purify($incident['risk_cause_body'] ?? ''),
                'kri_body' => strip_tags(purify($incident['kri_body'] ?? '')),
                'kri_unit_id' => $incident['kri_unit'],
                'kri_threshold_safe' => strip_tags(purify($incident['kri_threshold_safe'] ?? '')),
                'kri_threshold_caution' => strip_tags(purify($incident['kri_threshold_caution'] ?? '')),
                'kri_threshold_danger' => strip_tags(purify($incident['kri_threshold_danger'] ?? '')),
            ];
        }, $validated['incidents'] ?? []);
        $data['mitigations'] = array_map(function ($mitigation) {
            return [
                'risk_cause_number' => strip_tags(purify($mitigation['risk_cause_number'] ?? '')),
                'risk_treatment_option_id' => (int) $mitigation['risk_treatment_option'],
                'risk_treatment_type_id' => (int) $mitigation['risk_treatment_type'],
                'mitigation_plan' => purify($mitigation['mitigation_plan'] ?? ''),
                'mitigation_output' => purify($mitigation['mitigation_output'] ?? ''),
                'mitigation_start_date' => $mitigation['mitigation_start_date'],
                'mitigation_end_date' => $mitigation['mitigation_end_date'],
                'mitigation_cost' => (float) $mitigation['mitigation_cost'],
                'mitigation_rkap_program_type_id' => (int) $mitigation['mitigation_rkap_program_type'],
                'sub_unit_code' => $mitigation['sub_unit_code']
            ];
        }, $validated['mitigations'] ?? []);
        $dto = WorksheetRequestDTO::fromArray($data);
        $dto->incidents = $dto->incidents->unique('risk_cause_number');

        try {
            DB::beginTransaction();
            $worksheet = $this->worksheetService->create($dto);
            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => role()->getCurrentRole()->name,
                'status' => DocumentStatus::DRAFT->value,
                'note' => 'Membuat kertas kerja baru'
            ];

            if (role()->getCurrentRole()->name == 'risk admin') {
                $history = array_merge($history, [
                    'receiver_id' => 3,
                    'receiver_role' => 'risk owner',
                ]);
            } else {
                $history = array_merge($history, [
                    'receiver_id' => role()->getCurrentRole()->id,
                    'receiver_role' => role()->getCurrentRole()->name,
                ]);
            }

            $history = $worksheet->last_history()->create($history);
            DB::commit();

            return response()->json([
                'message' => 'Kertas kerja berhasil dibuat',
                'data' => [
                    'redirect' => route('risk.worksheet.show', $worksheet->getEncryptedId())
                ]
            ])->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat kertas kerja',
                'error' => $e->getMessage()
            ], ResponseStatus::HTTP_BAD_REQUEST);
        }
    }

    public function show(string $worksheet)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheet);
        $worksheet->identification = WorksheetIdentification::identificationQuery()->whereWorksheetId($worksheet->id)->firstOrFail();
        $worksheet->load('strategies', 'incidents.mitigations');

        if (request()->ajax()) {
            $identification = (array) $worksheet->identification;
            $identification['id'] = $identification['id'];
            $identification['risk_category_t2'] = $identification['risk_category_t2_id'];
            $identification['risk_category_t3'] = $identification['risk_category_t3_id'];
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
                    'risk_qualification' => $worksheet->risk_qualification_id,
                    'target_body' => $worksheet->target_body,
                    'unit_name' => $worksheet->sub_unit_name,
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
                    $incident['kri_unit'] = (string) $incident['kri_unit']['id'];
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

    public function update(UpdateWorksheetRequest $request, string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $worksheet->load('last_history');
        $hasAlreadyApproved = $worksheet->histories()->where('status', DocumentStatus::APPROVED->value)->exists();

        try {
            $validated = $request->validated();
            $data['context'] = [
                'worksheet_number' => strip_tags(purify($validated['context']['risk_number'])),
                'company_code' => 'API',
                'company_name' => 'PT Angkasa Pura Indonesia',
                'target_body' => purify($validated['context']['target_body']),
                'risk_number' => strip_tags(purify($validated['context']['risk_number'])),
            ];

            $data['strategies'] = array_map(function ($strategy) {
                return [
                    'id' => (int) $strategy['id'] ?? null,
                    'body' => purify($strategy['strategy_body'] ?? ''),
                    'expected_feedback' => purify($strategy['strategy_expected_feedback'] ?? ''),
                    'risk_value' => purify($strategy['strategy_risk_value'] ?? ''),
                    'risk_value_limit' => (float) $strategy['strategy_risk_value_limit'],
                    'decision' => $strategy['strategy_decision'],
                ];
            }, $validated['strategies'] ?? []);

            $data['identification'] = [
                'risk_category_t2_id' => $validated['identification']['risk_category_t2'],
                'risk_category_t3_id' => $validated['identification']['risk_category_t3'],
                'risk_chronology_body' => purify($validated['identification']['risk_chronology_body'] ?? ''),
                'risk_chronology_description' => purify($validated['identification']['risk_chronology_description'] ?? ''),
                'existing_control_type_id' => $validated['identification']['existing_control_type'],
                'existing_control_body' => purify($validated['identification']['existing_control_body'] ?? ''),
                'control_effectiveness_assessment_id' => $validated['identification']['control_effectiveness_assessment'],
                'risk_impact_category' => $validated['identification']['risk_impact_category'],
                'risk_impact_body' => purify($validated['identification']['risk_impact_body'] ?? ''),
                'risk_impact_start_date' => $validated['identification']['risk_impact_start_date'],
                'risk_impact_end_date' => $validated['identification']['risk_impact_end_date'],
                'inherent_body' => purify($validated['identification']['inherent_body'] ?? ''),
                'inherent_impact_value' => (float) $validated['identification']['inherent_impact_value'],
                'inherent_impact_scale_id' => $validated['identification']['inherent_impact_scale'],
                'inherent_impact_probability' => (int) $validated['identification']['inherent_impact_probability'],
                'inherent_impact_probability_scale_id' => $validated['identification']['inherent_impact_probability_scale'],
                'inherent_risk_exposure' => (float) $validated['identification']['inherent_risk_exposure'],
            ];

            for ($i = 1; $i <= 4; $i++) {
                $data['identification']["residual_{$i}_impact_value"] = (float) $validated['identification']['residual'][$i]['impact_value'] ?? 0;
                $data['identification']["residual_{$i}_impact_scale_id"] = $validated['identification']['residual'][$i]['impact_scale'] ?? null;
                $data['identification']["residual_{$i}_impact_probability"] = (int) $validated['identification']['residual'][$i]['impact_probability'] ?? 0;
                $data['identification']["residual_{$i}_impact_probability_scale_id"] = $validated['identification']['residual'][$i]['impact_probability_scale'] ?? null;
                $data['identification']["residual_{$i}_risk_exposure"] = (float) $validated['identification']['residual'][$i]['risk_exposure'] ?? 0;
            }

            $data['incidents'] = array_map(function ($incident) {
                return [
                    'id' => (int) $incident['id'] ?? null,
                    'risk_cause_number' => strip_tags(purify($incident['risk_cause_number'] ?? '')),
                    'risk_cause_code' => strip_tags(purify($incident['risk_cause_code'] ?? '')),
                    'risk_cause_body' => purify($incident['risk_cause_body'] ?? ''),
                    'kri_body' => strip_tags(purify($incident['kri_body'] ?? '')),
                    'kri_unit_id' => $incident['kri_unit'] ?? null,
                    'kri_threshold_safe' => strip_tags(purify($incident['kri_threshold_safe'] ?? '')),
                    'kri_threshold_caution' => strip_tags(purify($incident['kri_threshold_caution'] ?? '')),
                    'kri_threshold_danger' => strip_tags(purify($incident['kri_threshold_danger'] ?? '')),
                ];
            }, $validated['incidents'] ?? []);
            $data['mitigations'] = array_map(function ($mitigation) {
                return [
                    'id' => (int) $mitigation['id'] ?? null,
                    'risk_cause_number' => strip_tags(purify($mitigation['risk_cause_number'] ?? '')),
                    'risk_treatment_option_id' => (int) $mitigation['risk_treatment_option'],
                    'risk_treatment_type_id' => (int) $mitigation['risk_treatment_type'],
                    'mitigation_plan' => purify($mitigation['mitigation_plan'] ?? ''),
                    'mitigation_output' => purify($mitigation['mitigation_output'] ?? ''),
                    'mitigation_start_date' => $mitigation['mitigation_start_date'],
                    'mitigation_end_date' => $mitigation['mitigation_end_date'],
                    'mitigation_cost' => (float) $mitigation['mitigation_cost'],
                    'mitigation_rkap_program_type_id' => (int) $mitigation['mitigation_rkap_program_type'],
                    'sub_unit_code' => $mitigation['sub_unit_code']
                ];
            }, $validated['mitigations'] ?? []);

            $dto = WorksheetRequestDTO::fromArray($data);
            $dto->incidents = $dto->incidents->unique('risk_cause_number');

            if ($hasAlreadyApproved) {
                $dto->context->status = DocumentStatus::APPROVED->value;
            }

            DB::beginTransaction();
            $worksheet = $this->worksheetService->update($worksheet, $dto);

            if ($hasAlreadyApproved) {
                $worksheet->histories()->create([
                    'created_by' => auth()->user()->employee_id,
                    'created_role' => 'risk owner',
                    'receiver_id' => $worksheet->last_history?->created_by,
                    'receiver_role' => $worksheet->last_history?->created_role,
                    'status' => DocumentStatus::APPROVED->value,
                    'note' => 'Kertas kerja berhasil diperbarui'
                ]);
            } else {
                $worksheet->histories()->create([
                    'created_by' => auth()->user()->employee_id,
                    'created_role' => role()->getCurrentRole()->name,
                    'receiver_id' => role()->getCurrentRole()->id,
                    'receiver_role' => role()->getCurrentRole()->name,
                    'status' => $worksheet->status,
                    'note' => 'Kertas kerja berhasil diperbarui'
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Kertas kerja berhasil diperbarui',
                'data' => [
                    'redirect' => route('risk.worksheet.show', $worksheet->getEncryptedId())
                ]
            ])->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Worksheet] ' . $e->getMessage(), [$e]);
            return response()
                ->json(['message' => 'Gagal memperbarui kertas kerja'], ResponseStatus::HTTP_INTERNAL_SERVER_ERROR)
                ->header('Cache-Control', 'no-store');
        }
    }

    public function destroy(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        if (in_array($worksheet->status, [DocumentStatus::DRAFT->value, DocumentStatus::ON_REVIEW->value])) {
            if ($worksheet->delete()) {
                flash_message('flash_message', 'Kertas kerja berhasil dihapus', State::SUCCESS);
                return redirect()->route('risk.assessment.index');
            }

            flash_message('flash_message', 'Gagal menghapus kertas kerja', State::ERROR);
        } else {
            flash_message('flash_message', 'Gagal menghapus kertas kerja, kertas kerja sedang dalam proses atau sudah disetujui', State::ERROR);
        }

        return redirect()->back();
    }

    public function update_status(string $worksheetId, Request $request)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);

        try {
            $rule = Str::snake(role()->isRiskAnalis() || role()->isAdministrator() ? $request->role : role()->getCurrentRole()->name) . '_rule';
            if (!method_exists($this, $rule)) {
                throw new Exception("Target role not found: {$rule}");
            }
            DB::beginTransaction();
            $this->$rule($worksheet, strip_tags(purify($request->status)), purify($request->note));
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
            $creatorUnit = $worksheet->creator?->units()
                ->where('sub_unit_code', $worksheet->sub_unit_code)
                ->first();

            $role = $creatorUnit->roles()->first();
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
        $unit = role()->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                role()->isRiskOwner() || role()->isRiskAdmin()
            ) ?: $unit;
        }

        $worksheets = Worksheet::assessmentQuery()
            ->when(
                !role()->isRiskAdmin(),
                fn($q) => $q->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        role()->isRiskOwner() || role()->isRiskAdmin()
                    )
                )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            )
            ->when(
                role()->isRiskAdmin(),
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
        $unit = role()->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                role()->isRiskOwner() || role()->isRiskAdmin()
            ) ?: $unit;
        }

        $quarter = request('quarter', 1);
        $quarter = in_array($quarter, [1, 2, 3, 4]) ? $quarter : 1;

        $worksheets = Worksheet::residualMapQuery($quarter)
            ->when(
                !role()->isRiskAdmin(),
                fn($q) => $q->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        role()->isRiskOwner() || role()->isRiskAdmin()
                    )
                )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            )
            ->when(
                role()->isRiskAdmin(),
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
        $unit = role()->getCurrentUnit();
        if (request('unit')) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit'),
                role()->isRiskOwner() || role()->isRiskAdmin()
            ) ?: $unit;
        }

        $worksheets = Worksheet::latestMonitoringWithMitigationQuery()
            ->when(
                !role()->isRiskAdmin(),
                fn($q) => $q->withExpression(
                    'position_hierarchy',
                    Position::hierarchyQuery(
                        $unit?->sub_unit_code ?? '-',
                        role()->isRiskOwner() || role()->isRiskAdmin()
                    )
                )
                    ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            )
            ->when(
                role()->isRiskAdmin(),
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
