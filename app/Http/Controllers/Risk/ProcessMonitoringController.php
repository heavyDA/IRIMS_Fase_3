<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\Master\IncidentCategory;
use App\Models\Master\IncidentFrequency;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Risk\Assessment\Worksheet;
use App\Models\Risk\Assessment\WorksheetMonitoring;
use App\Models\Risk\Assessment\WorksheetMonitoringHistory;
use App\Models\Risk\Assessment\WorksheetStrategy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProcessMonitoringController extends Controller
{
    public function index()
    {
        $title = 'Risk Monitoring';
        if (request()->ajax()) {
            $worksheets = WorksheetStrategy::query()
                ->select([
                    'ra_worksheet_strategies.*',
                    'ra_worksheet_targets.body as target_body',

                ])
                ->join('ra_worksheet_targets', 'ra_worksheet_targets.id', '=', 'ra_worksheet_strategies.worksheet_target_id')
                ->with(['target.worksheet'])
                ->whereHas('target.worksheet.last_history', fn($query) => $query->where('status', '=', DocumentStatus::APPROVED->value));

            return DataTables::eloquent($worksheets)
                ->addColumn('encrypted_id', function ($strategy) {
                    return $strategy->target->worksheet->getEncryptedId();
                })
                ->addColumn('status_monitoring', function ($strategy) {
                    $status = DocumentStatus::tryFrom($strategy->target->worksheet->status_monitoring);
                    $class = $status->color();
                    $route = route('risk.process.monitoring.show', $strategy->target->worksheet->getEncryptedId());
                    $key = $strategy->target->worksheet->id;

                    return view('risk.process.monitoring._table_status', compact('status', 'class', 'route', 'key'))->render();
                })
                ->rawColumns(['status_monitoring'])
                ->make(true);
        }
        return view('risk.process.index', compact('title'));
    }

    public function show(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
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

            'monitorings',
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

        $title = 'Risk Monitoring';
        return view('risk.process.monitoring.index', compact('title', 'worksheet'));
    }

    public function create(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
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

            'monitorings',
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

        $isQuantitative = $worksheet->target->identification->risk_impact_category == 'kuantitatif';

        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $frequencies = IncidentFrequency::all();
        $incident_categories = IncidentCategory::all();

        $title = 'Form Risk Monitoring';
        return view('risk.process.monitoring.create', compact(
            'title',
            'worksheet',
            'isQuantitative',
            'kbumn_risk_categories',
            'frequencies',
            'incident_categories'
        ));
    }

    public function store(string $worksheetId, Request $request)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $user = auth()->user();
        try {
            $monitoring = $worksheet->monitorings()->create([
                'period_date' => $request->residual['period_date'],
                'created_by' => $user->employee_id,
                'status' => DocumentStatus::DRAFT->value
            ]);
            $monitoring->alteration()->create($request->alteration);

            $residual = $request->residual;
            if ($residual['residual']) {
                foreach ($residual['residual'] ?? [] as $key => $item) {
                    if ($item) {
                        foreach ($item as $key => $value) {
                            if ($key == 'impact_scale' || $key == 'impact_probability_scale') {
                                $residual[$key . '_id'] = $value == 'Pilih' ? null : $value;
                            } else {
                                $residual[$key] = $value ?: '';
                            }
                        }
                        break;
                    }
                }
            }

            unset($residual['residual'], $residual['inherent_body'], $residual['period_date']);
            $monitoring->residual()->create($residual);

            $incident = [];
            foreach ($request->incident as $key => $value) {
                if (str_contains($key, 'category') || $key == 'incident_frequency') {
                    $incident[$key . '_id'] = $value == 'Pilih' ? null : $value;
                } else if ($key == 'incident_repetitive' || $key == 'insurance_status') {
                    $incident[$key] = $value == 'Pilih' || $value == '0' ? false : $value;
                } else {
                    $incident[$key] = $value ?: '';
                }
            }
            $monitoring->incident()->create($incident);

            $actualizations = [];
            foreach ($request->actualizations as $actual) {
                $actualization = [];

                foreach ($actual as $key => $value) {
                    if (str_contains($key, 'actualization_progress')) {
                        if ($value && !is_string($value)) {
                            foreach ($value as $v) {
                                if ($v) {
                                    $actualization['actualization_progress'] = $v;
                                }
                            }
                        }
                    } else if (str_contains($key, 'kri')) {
                        $actualization[str_replace('actualization_', '', $key)] = $value ?: '';
                    } else if ($key == 'mitigation_id') {
                        $actualization['worksheet_incident_' . $key] = $value ?: null;
                    } else {
                        $actualization[$key] = $value ?: '';
                    }
                }

                $actualizations[] = $actualization;
            }

            $monitoring->actualizations()->createMany($actualizations);
            $monitoring->histories()->create([
                'created_by' => $user->employee_id,
                'created_role' => 'risk admin',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => DocumentStatus::DRAFT->value,
                'note' => 'Membuat laporan monitoring baru'
            ]);

            $worksheet->update(['status_monitoring' => DocumentStatus::ON_PROGRESS_MONITORING->value]);

            DB::commit();
            return response()->json([
                'message' => 'Laporan monitoring berhasil disimpan',
                'data' => [
                    'redirect' => route('risk.process.monitoring.show', $worksheet->getEncryptedId())
                ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);

            return response()->json([
                'message' => 'Gagal menyimpan laporan monitoring',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show_monitoring(string $monitoringId)
    {
        $monitoring = WorksheetMonitoring::findByEncryptedIdOrFail($monitoringId);
        $monitoring->load([
            'residual.impact_scale',
            'residual.impact_probability_scale',
            'actualizations',
            'alteration',
            'incident',
            'histories',
            'last_history',
        ]);

        $worksheet = Worksheet::findOrFail($monitoring->worksheet_id);
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
            'target.strategies'
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

        $title = 'Risk Monitoring';
        return view('risk.process.monitoring.show', compact('title', 'worksheet', 'monitoring'));
    }

    public function edit_monitoring(string $monitoringId)
    {
        $monitoring = WorksheetMonitoring::findByEncryptedIdOrFail($monitoringId);
        $monitoring->load([
            'residual',
            'actualizations',
            'alteration',
            'incident',
        ]);
        $worksheet = Worksheet::findOrFail($monitoring->worksheet_id);
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

            'monitorings',
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

        $isQuantitative = $worksheet->target->identification->risk_impact_category == 'kuantitatif';

        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $frequencies = IncidentFrequency::all();
        $incident_categories = IncidentCategory::all();

        $title = 'Form Risk Monitoring';
        return view('risk.process.monitoring.create', compact(
            'title',
            'monitoring',
            'worksheet',
            'isQuantitative',
            'kbumn_risk_categories',
            'frequencies',
            'incident_categories'
        ));
    }

    public function update_status_monitoring(string $monitoringId, Request $request)
    {
        $monitoring = WorksheetMonitoring::findByEncryptedIdOrFail($monitoringId);
        $currentRole = session()->get('current_role');

        $rule = Str::snake($currentRole->name) . '_rule';

        try {
            DB::beginTransaction();
            $this->$rule($monitoring, $request->status, $request->note);
            DB::commit();

            flash_message('flash_message', 'Status berhasil diperbarui', State::SUCCESS);
            return redirect()->route('risk.process.monitoring.show_monitoring', $monitoringId);
        } catch (Exception $e) {
            DB::rollBack();
            flash_message('flash_message', $e->getMessage(), State::ERROR);
            return redirect()->route('risk.process.monitoring.show_monitoring', $monitoringId);
        }
    }

    protected function risk_admin_rule(WorksheetMonitoring $monitoring, string $status, string $note): WorksheetMonitoringHistory
    {
        $monitoring->update(['status' => DocumentStatus::ON_REVIEW->value]);
        return $monitoring->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk admin',
            'receiver_id' => 3,
            'receiver_role' => 'risk owner',
            'status' => DocumentStatus::ON_REVIEW->value,
            'note' => $note
        ]);
    }

    protected function risk_owner_rule(WorksheetMonitoring $monitoring, string $status, string $note): WorksheetMonitoringHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::DRAFT) {
            $monitoring->update(['status' => $status->value]);
            return $monitoring->histories()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk owner',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => $status->value,
                'note' => $note
            ]);
        }

        $monitoring->update(['status' => DocumentStatus::ON_CONFIRMATION->value]);
        return $monitoring->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk owner',
            'receiver_id' => 4,
            'receiver_role' => 'risk otorisator',
            'status' => DocumentStatus::ON_CONFIRMATION->value,
            'note' => $note
        ]);
    }

    protected function risk_otorisator_rule(WorksheetMonitoring $monitoring, string $status, string $note): WorksheetMonitoringHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::ON_REVIEW) {
            $monitoring->update(['status' => $status->value]);
            return $monitoring->histories()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk otorisator',
                'receiver_id' => 3,
                'receiver_role' => 'risk owner',
                'status' => $status->value,
                'note' => $note
            ]);
        }

        $monitoring->update(['status' => DocumentStatus::APPROVED->value]);
        return $monitoring->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk otorisator',
            'receiver_id' => 2,
            'receiver_role' => 'risk admin',
            'status' => DocumentStatus::APPROVED->value,
            'note' => $note
        ]);
    }
}
