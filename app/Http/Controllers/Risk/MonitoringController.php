<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Exceptions\Services\UploadFileException;
use App\Http\Controllers\Controller;
use App\Models\Master\IncidentCategory;
use App\Models\Master\IncidentFrequency;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Models\Risk\Monitoring;
use App\Models\Risk\MonitoringHistory;
use App\Models\Risk\WorksheetIdentification;
use App\Services\PositionService;
use App\Services\UploadFileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MonitoringController extends Controller
{
    public function __construct(
        private PositionService $positionService,
        private UploadFileService $uploadFileService
    ) {}

    public function index()
    {
        if (request()->ajax()) {
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
                ->when(request('risk_qualification'), fn($q) => $q->where('w.risk_qualification_id', request('risk_qualification')));

            return DataTables::query($worksheets)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('w.status_monitoring', '%' . $value . '%')
                                ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                                ->orWhereLike('w.target_body', '%' . $value . '%')
                                ->orWhereLike('w.risk_chronology_body', '%' . $value . '%')
                                ->orWhereLike('wmit.mitigation_plan', '%' . $value . '%')
                                ->orWhereLike('ma.actualization_plan_output', '%' . $value . '%')
                                ->orWhereLike('hi.risk_level', '%' . $value . '%')
                                ->orWhereLike('hi.risk_scale', '%' . $value . '%')
                                ->orWhereLike('ma.quarter', '%' . $value . '%')
                                ->orWhereLike('mr.risk_level', '%' . $value . '%')
                                ->orWhereLike('mr.risk_scale', '%' . $value . '%')
                        );
                    }
                })
                ->editColumn('status_monitoring', function ($worksheet) {
                    $key = $worksheet->worksheet_id;
                    $status = DocumentStatus::tryFrom($worksheet->status_monitoring);
                    $class = $status->color();
                    $worksheet_number = $worksheet->worksheet_number;
                    $route = route('risk.monitoring.show', Crypt::encryptString($key));

                    return view('risk.monitoring._table_status', compact('status', 'class', 'key', 'worksheet_number', 'route'))->render();
                })
                ->orderColumn('worksheet_number', 'w.worksheet_number $1')
                ->orderColumn('status_monitoring', 'w.status_monitoring $1')
                ->orderColumn('target_body', 'w.target_body $1')
                ->orderColumn('risk_chronology_body', 'w.risk_chronology_body $1')
                ->orderColumn('mitigation_plan', 'wmit.mitigation_plan $1')
                ->orderColumn('actualization_plan_output', 'ma.actualization_plan_output $1')
                ->orderColumn('inherent_risk_level', 'w.inherent_risk_level $1')
                ->orderColumn('inherent_risk_scale', 'w.inherent_risk_scale $1')
                ->orderColumn('residual_risk_level', 'mr.risk_level $1')
                ->orderColumn('residual_risk_scale', 'mr.risk_scale $1')
                ->orderColumn('created_at', 'lm.created_at $1')
                ->rawColumns(['status_monitoring'])
                ->make(true);
        }

        $title = 'Risk Monitoring';
        return view('risk.process.index', compact('title'));
    }

    public function show(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $worksheet->identification = WorksheetIdentification::identificationQuery()->whereWorksheetId($worksheet->id)->firstOrFail();
        $worksheet->load('strategies', 'incidents.mitigations', 'monitorings');
        $title = 'Laporan Risk Monitoring';
        return view('risk.monitoring.index', compact('title', 'worksheet'));
    }

    public function create(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $worksheet->identification = WorksheetIdentification::identificationQuery()->whereWorksheetId($worksheet->id)->firstOrFail();
        if (request()->ajax()) {
            $worksheet->load('incidents.mitigations');

            $actualizations = [];
            $quarter = ceil(date('m') / 3);
            $residual = [
                'period_date' => date('Y-m-d'),
                'quarter' => $quarter,
                'risk_chronology_body' => $worksheet->identification->risk_chronology_body,
                'risk_impact_category' => $worksheet->identification->risk_impact_category,
                'risk_mitigation_effectiveness' => '',
            ];

            $actualizationsIndex = 0;
            $worksheet->incidents->each(function ($incident) use ($quarter, &$actualizations, &$actualizationsIndex) {
                $incident->mitigations->each(function ($mitigation) use ($incident, $quarter, &$actualizations, &$actualizationsIndex) {
                    $actualizations[] = [
                        'key' => $actualizationsIndex,
                        'risk_cause_number' => $incident->risk_cause_number,
                        'actualization_mitigation_id' => $mitigation->id,
                        'actualization_mitigation_plan' => $mitigation->mitigation_plan,
                        'actualization_cost' => '',
                        'actualization_cost_absorption' => '',
                        'quarter' => $quarter,
                        'actualization_documents' => [],
                        'actualization_kri' => $incident->kri_body,
                        'actualization_kri_threshold' => '',
                        'actualization_kri_threshold_score' => '',
                        'actualization_plan_body' => '',
                        'actualization_plan_output' => '',
                        "actualization_plan_progress[{$quarter}]" => '',
                        'actualization_plan_status' => '',
                        'actualization_plan_explanation' => '',
                        'actualization_pic' => $mitigation->mitigation_pic,
                        'actualization_pic_related' => '',
                    ];

                    $actualizationsIndex +=  1;
                });
            });

            $residualTargets = [];
            for ($i = 1; $i <= 4; $i++) {
                $riskLevel = "residual_{$i}_risk_level";
                $riskScale = "residual_{$i}_risk_scale";
                $residualTargets[] = [
                    'quarter' => $i,
                    'risk_level' => $worksheet->identification->$riskLevel,
                    'risk_scale' => (int) $worksheet->identification->$riskScale ?? '',
                ];
            }

            return response()->json([
                'data' => [
                    'inherent' => [
                        'risk_level' => $worksheet->identification->inherent_risk_level,
                        'risk_scale' => $worksheet->identification->inherent_risk_scale,
                    ],
                    'residual' => $residual,
                    'residual_target' => $residualTargets,
                    'actualizations' => $actualizations
                ]
            ])->header('Cache-Control', 'no-store');
        }

        $worksheet->load('strategies', 'incidents.mitigations', 'monitorings');

        $isQuantitative = $worksheet->identification->risk_impact_category == 'kuantitatif';

        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $frequencies = IncidentFrequency::all();
        $incident_categories = IncidentCategory::all();

        $title = 'Form Risk Monitoring';
        return view('risk.monitoring.create', compact(
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
        $directory = '';
        $user = auth()->user();

        try {
            DB::beginTransaction();
            $monitoring = $worksheet->monitorings()->create([
                'period_date' => $request->residual['period_date'],
                'created_by' => $user->employee_id,
                'status' => DocumentStatus::DRAFT->value
            ]);

            $monitoring->residual()->create($this->residualRequestMapping($request->residual));
            $monitoring->alteration()->create(['body' => '', 'impact' => '', 'description' => '']);
            $monitoring->incident()->create($this->incidentRequestMapping([]));

            $actualizations = [];
            foreach ($request->actualizations as $actual) {
                $actualizations[] = $this->actualizationRequestMapping($actual);
            }

            $actualizations = $monitoring->actualizations()->createMany($actualizations);
            $monitoring->histories()->create([
                'created_by' => $user->employee_id,
                'created_role' => 'risk admin',
                'receiver_id' => 2,
                'receiver_role' => 'risk admin',
                'status' => DocumentStatus::DRAFT->value,
                'note' => 'Membuat laporan monitoring baru'
            ]);

            $worksheet->update(['status_monitoring' => DocumentStatus::ON_PROGRESS_MONITORING->value]);


            foreach ($request->actualizations as $key => $item) {
                $directory = $user->sub_unit_code
                    . '/risk_monitoring/'
                    . $monitoring->period_date_format->translatedFormat('F');

                if (!Storage::disk('s3')->exists($directory)) {
                    Storage::disk('s3')->makeDirectory($directory);
                }

                $documents = [];
                if ($request->hasFile("actualizations.{$key}.actualization_documents")) {
                    $files = $request->file("actualizations.{$key}.actualization_documents");
                    if ($files) {
                        foreach ($files as $file) {
                            if ($file->isValid()) {
                                $documents[] = $this->uploadFileService->store($file, $directory, 's3');
                            }
                        }
                    }
                }

                if ($documents) {
                    $actualizations[$key]->update(['documents' => $documents]);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Laporan monitoring berhasil disimpan',
                'data' => [
                    'redirect' => route('risk.monitoring.show', $worksheet->getEncryptedId())
                ],
            ])->header('Cache-Control', 'no-store');
        } catch (UploadFileException $e) {
            DB::rollBack();
            logger()->error($e);

            return response()->json([
                'message' => 'Gagal menyimpan laporan monitoring, terjadi kesalahan saat mengunggah dokumen pendukung',
            ], Response::HTTP_BAD_REQUEST)->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);

            return response()->json([
                'message' => 'Gagal menyimpan laporan monitoring',
            ], Response::HTTP_BAD_REQUEST)->header('Cache-Control', 'no-store');
        }
    }

    public function show_monitoring(string $monitoring_id)
    {
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        $worksheet = Worksheet::findOrFail($monitoring->worksheet_id);

        if (
            session()->get('current_role')?->name == 'risk admin' &&
            $worksheet->created_by != auth()->user()->employee_id
        ) {
            abort(404, 'Data tidak ditemukan');
        }

        $worksheet->load('monitorings');

        $monitoringMonths = array_fill(0, 11, 0);
        foreach ($worksheet->monitorings as $monitoring) {
            $month = format_date($monitoring->period_date)->month - 1;
            if (array_key_exists($month, $monitoringMonths)) {
                $monitoringMonths[$month] = 1;
            }
        }

        $monitoring->load([
            'residual.impact_scale',
            'residual.impact_probability_scale',
            'residual',
            'actualizations.mitigation.incident',
            'alteration',
            'incident',
            'histories',
            'last_history',
        ]);

        $worksheet->identification = WorksheetIdentification::identificationQuery()->whereWorksheetId($worksheet->id)->firstOrFail();

        $title = 'Risk Monitoring';
        return view('risk.monitoring.show', compact('title', 'worksheet', 'monitoring', 'monitoringMonths'));
    }

    public function edit_monitoring(string $monitoring_id)
    {
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        $monitoring->load([
            'residual.impact_scale',
            'residual.impact_probability_scale',
            'residual.incident',
            'actualizations.mitigation.incident',
            'alteration',
            'incident',
            'histories',
            'last_history',
        ]);

        $worksheet = Worksheet::findOrFail($monitoring->worksheet_id);
        $worksheet->identification = WorksheetIdentification::identificationQuery()->whereWorksheetId($worksheet->id)->firstOrFail();

        if (request()->ajax()) {
            $residual = [
                'period_date' => $monitoring->period_date,
                'risk_chronology_body' => $worksheet->identification->risk_chronology_body,
                'risk_impact_category' => $worksheet->identification->risk_impact_category,
                'risk_mitigation_effectiveness' => $monitoring->residual->risk_mitigation_effectiveness,
                'impact_probability' => 0,
                'impact_probability_scale' => null,
                'impact_scale' => null,
                'impact_value' => 0,
                'risk_exposure' => '',
                'risk_level' => '',
                'risk_scale' => '',
                'quarter' => $monitoring->residual->quarter,
            ];

            for ($i = 0; $i <= 4; $i++) {
                if ($i == $monitoring->residual->quarter) {
                    $residual['impact_probability'] =     $monitoring->residual->impact_probability;
                    $residual['impact_probability_scale'] = $monitoring->residual->impact_probability_scale_id ?? '';
                    $residual['impact_scale'] = $monitoring->residual->impact_scale_id ?? '';
                    $residual['impact_value'] = $monitoring->residual->impact_value;
                    $residual['risk_exposure'] = $monitoring->residual->risk_exposure;
                    $residual['risk_level'] = $monitoring->residual->risk_level;
                    $residual['risk_scale'] = $monitoring->residual->risk_scale;
                    break;
                }
            }

            $actualizations = [];
            foreach ($monitoring->actualizations as $index => $actualization) {
                $actualizations[] = [
                    'key' => $index,
                    'id' => $monitoring->actualizations[$index]->id,
                    'risk_cause_number' => $actualization->mitigation->incident->risk_cause_number,
                    'risk_cause_body' => $actualization->mitigation->incident->risk_cause_body,
                    'actualization_mitigation_id' => $actualization->mitigation->id,
                    'actualization_mitigation_plan' => $actualization->mitigation->mitigation_plan,
                    'actualization_cost' => $monitoring->actualizations[$index]->actualization_cost,
                    'actualization_cost_absorption' => $monitoring->actualizations[$index]->actualization_cost_absorption,
                    'quarter' => $monitoring->residual->quarter,
                    'actualization_documents' => $monitoring->actualizations[$index]->documents,
                    'actualization_kri' => $actualization->mitigation->incident->kri_body,
                    'actualization_kri_threshold' => $monitoring->actualizations[$index]->kri_threshold ?? '',
                    'actualization_kri_threshold_score' => $monitoring->actualizations[$index]->kri_threshold_score ?? '',
                    'actualization_plan_body' => $monitoring->actualizations[$index]->actualization_plan_body,
                    'actualization_plan_output' => $monitoring->actualizations[$index]->actualization_plan_output,
                    "actualization_plan_progress[{$monitoring->residual->quarter}]" => $monitoring->actualizations[$index]->actualization_plan_progress,
                    'actualization_plan_status' => $monitoring->actualizations[$index]->actualization_plan_status,
                    'actualization_plan_explanation' => $monitoring->actualizations[$index]->actualization_plan_explanation,
                    'actualization_pic' => $actualization->mitigation->mitigation_pic,
                    'actualization_pic_related' => $monitoring->actualizations[$index]->unit_code,
                ];
            }

            $alteration = [
                'body' => $monitoring->alteration->body,
                'impact' => $monitoring->alteration->impact,
                'description' => $monitoring->alteration->description
            ];

            $incident = [
                'incident_body' => $monitoring->incident->incident_body,
                'incident_identification' => $monitoring->incident->incident_identification,
                'incident_category' => $monitoring->incident->incident_category_id,
                'incident_source' => $monitoring->incident->incident_source,
                'incident_cause' => $monitoring->incident->incident_cause,
                'incident_handling' => $monitoring->incident->incident_handling,
                'incident_description' => $monitoring->incident->incident_description,
                'risk_category_t2' => $monitoring->incident->risk_category_t2_id,
                'risk_category_t3' => $monitoring->incident->risk_category_t3_id,
                'loss_description' => $monitoring->incident->loss_description,
                'loss_value' => $monitoring->incident->loss_value,
                'incident_repetitive' => $monitoring->incident->incident_repetitive,
                'incident_frequency' => $monitoring->incident->incident_frequency_id,
                'mitigation_plan' => $monitoring->incident->mitigation_plan,
                'actualization_plan' => $monitoring->incident->actualization_plan,
                'follow_up_plan' => $monitoring->incident->follow_up_plan,
                'related_party' => $monitoring->incident->related_party,
                'insurance_status' => $monitoring->incident->insurance_status,
                'insurance_permit' => $monitoring->incident->insurance_permit,
                'insurance_claim' => $monitoring->incident->insurance_claim,
            ];

            $residualTargets = [];
            for ($i = 1; $i <= 4; $i++) {
                $riskLevel = "residual_{$i}_risk_level";
                $riskScale = "residual_{$i}_risk_scale";
                $residualTargets[] = [
                    'quarter' => $i,
                    'risk_level' => $worksheet->identification->$riskLevel,
                    'risk_scale' => (int) $worksheet->identification->$riskScale ?? '',
                ];
            }

            return response()->json([
                'data' => [
                    'inherent' => [
                        'risk_level' => $worksheet->identification->inherent_risk_level,
                        'risk_scale' => $worksheet->identification->inherent_risk_scale,
                    ],
                    'residual' => $residual,
                    'residual_target' => $residualTargets,
                    'actualizations' => $actualizations,
                    'alteration' => $alteration,
                    'incident' => $incident,
                ]
            ])->header('Cache-Control', 'no-store');
        }


        $isQuantitative = $worksheet->identification->risk_impact_category == 'kuantitatif';
        $kbumn_risk_categories = KBUMNRiskCategory::all()->groupBy('type', true);
        $frequencies = IncidentFrequency::all();
        $incident_categories = IncidentCategory::all();

        $title = 'Form Risk Monitoring';
        return view('risk.monitoring.edit', compact(
            'title',
            'monitoring',
            'worksheet',
            'isQuantitative',
            'kbumn_risk_categories',
            'frequencies',
            'incident_categories'
        ));
    }

    public function update_monitoring(string $monitoring_id, Request $request)
    {
        $user = auth()->user();
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        $monitoring->load('last_history');

        try {
            DB::beginTransaction();
            $monitoring->update(['period_date' => $request->residual['period_date']]);
            $monitoring->residual()->delete();
            $monitoring->residual()->create($this->residualRequestMapping($request->residual));

            $actualizations = [];
            $actualizations_new = [];
            foreach ($request->actualizations as $actual) {
                $actualization = $this->actualizationRequestMapping($actual);
                unset(
                    $actualization['actualization_documents'],
                    $actualization['key'],
                    $actualization['kri'],
                    $actualization['risk_cause_number'],
                    $actualization['actualization_mitigation_plan'],
                    $actualization['actualization_pic'],
                    $actualization['actualization_pic_related'],
                );

                if ($actual['id']) {
                    $actualization = $monitoring->actualizations->where('id', $actual['id'])->first();
                    $actualizations[] = $actualization->toArray();
                    $actualization->update($this->actualizationRequestMapping($actual));
                } else {
                    $actualizations_new[] = $actualization;
                }
            }

            $actualizations_new = $monitoring->actualizations()->createMany($actualizations_new)->toArray();

            $directory = $user->sub_unit_code
                . '/risk_monitoring/'
                . $monitoring->period_date_format->translatedFormat('F');
            foreach ($request->actualizations as $key => $item) {
                $documents = [];
                if ($request->hasFile("actualizations.{$item['key']}.actualization_documents")) {
                    $files = $request->file("actualizations.{$item['key']}.actualization_documents");
                    if ($files) {
                        foreach ($files as $file) {
                            if ($file->isValid()) {
                                $documents[] = $this->uploadFileService->store($file, $directory, 's3');
                            }
                        }
                    }
                }

                $files = $request->actualizations[$item['key']]['actualization_documents'];
                if ($files) {
                    foreach ($files as $key => $file) {
                        if (is_array($file)) {
                            $documents[] = $file;
                        }
                    }
                }

                if ($documents) {
                    if (array_key_exists($item['key'], $actualizations_new) && !$item['id']) {
                        $monitoring
                            ->actualizations()
                            ->where('id', $actualizations_new[$key]['id'])
                            ->update(['documents' => $documents]);
                        continue;
                    }

                    $index = array_search($item['id'], array_column($actualizations, 'id'));
                    $monitoring
                        ->actualizations()
                        ->where('id', $actualizations[$index]['id'])
                        ->update(['documents' => $documents]);
                }
            }

            $monitoring->histories()->create([
                'created_by' => $user->employee_id,
                'created_role' => session()->get('current_role')->name,
                'receiver_id' => 2,
                'receiver_role' => session()->get('current_role')->name,
                'status' => $monitoring->last_history->status,
                'note' => 'Memperbarui laporan monitoring'
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Laporan monitoring berhasil diperbarui.',
                'data' => [
                    'redirect' => route('risk.monitoring.show_monitoring', $monitoring_id)
                ]
            ])->header('Cache-Control', 'no-store');
        } catch (UploadFileException $e) {
            DB::rollBack();
            logger()->error('[Worksheet Monitoring] Update Monitoring with ID ' . $monitoring->id . ' ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal memperbarui laporan monitoring, terjadi kesalahan saat mengunggah dokumen pendukung',
            ], Response::HTTP_BAD_REQUEST)->header('Cache-Control', 'no-store');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Worksheet Monitoring] Update Monitoring with ID ' . $monitoring->id . ' ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memperbarui laporan monitoring'], Response::HTTP_BAD_REQUEST)->header('Cache-Control', 'no-store');
        }
    }

    public function destroy_monitoring(string $monitoring_id)
    {
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        $monitoring->load('worksheet');
        try {
            DB::beginTransaction();
            throw_if(!$monitoring->delete(), new Exception("Failed to delete monitoring report with ID {$monitoring->id}"));
            DB::commit();
            flash_message('flash_message', 'Laporan monitoring berhasil dihapus', State::SUCCESS);
            return redirect()->route('risk.monitoring.show', $monitoring->worksheet->getEncryptedId());
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Worksheet Monitoring] Failed to destroy Monitoring Report with ID ' . $monitoring->id . ' ' . $e->getMessage());
            flash_message('flash_message', 'Laporan monitoring gagal dihapus', State::ERROR);
            return redirect()->intended();
        }
    }

    public function update_status_monitoring(string $monitoring_id, Request $request)
    {
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        try {
            $rule = Str::snake(role()->isAdministrator() || role()->isRiskAnalis() ? $request->role : role()->getCurrentRole()->name) . '_rule';
            if (!method_exists($this, $rule)) {
                throw new Exception("Target role not found: {$rule}");
            }
            DB::beginTransaction();
            $this->$rule($monitoring, strip_tags(purify($request->status)), purify($request->note));
            DB::commit();

            flash_message('flash_message', 'Laporan monitoring berhasil disubmit.', State::SUCCESS);
        } catch (Exception $e) {
            DB::rollBack();
            flash_message('flash_message', 'Laporang monitorin gagal disubmit.', State::ERROR);
            logger()->error("[Monitoring] Failed to update status of monitoring with ID {$monitoring->id}: " . $e->getMessage());
        }
        return redirect()->route('risk.monitoring.show_monitoring', $monitoring_id);
    }

    protected function risk_admin_rule(Monitoring $monitoring, string $status, string $note): MonitoringHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status != DocumentStatus::ON_REVIEW) {
            $status = $status instanceof DocumentStatus ? $status->value : $status;
            throw new Exception("Attempt to update monitoring with ID {$monitoring->id} status from {$monitoring->status} to " . ($status ?? '')  . ' as Risk Admin');
        }

        $monitoring->update(['status' => DocumentStatus::ON_REVIEW->value]);
        return $monitoring->histories()->create([
            'created_by' => auth()->user()->employee_id,
            'created_role' => 'risk admin',
            'receiver_id' => 3,
            'receiver_role' => 'risk owner',
            'status' => $status->value,
            'note' => $note
        ]);
    }

    protected function risk_owner_rule(Monitoring $monitoring, string $status, string $note): MonitoringHistory
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
            throw new Exception("Attempt to update monitoring with ID {$monitoring->id} status from {$monitoring->status} to " . ($status ?? '')  . ' as Risk Owner');
        }

        $monitoring->update(['status' => $status->value]);

        return $monitoring->histories()->create($history);
    }

    protected function risk_otorisator_rule(Monitoring $monitoring, string $status, string $note): MonitoringHistory
    {
        $status = DocumentStatus::tryFrom($status);
        if ($status == DocumentStatus::ON_REVIEW) {
            return $monitoring->histories()->create([
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk otorisator',
                'receiver_id' => 3,
                'receiver_role' => 'risk owner',
                'status' => $status->value,
                'note' => $note
            ]);
        } else if ($status == DocumentStatus::APPROVED) {
            $role = $monitoring->worksheet->creator->roles()->first();

            $history = [
                'created_by' => auth()->user()->employee_id,
                'created_role' => 'risk otorisator',
                'receiver_id' => $role?->id ?? 2,
                'receiver_role' => $role?->name ?? 'risk admin',
                'status' => $status->value,
                'note' => $note
            ];
        } else {
            $status = $status instanceof DocumentStatus ? $status->value : $status;
            throw new Exception("Attempt to update monitoring with ID {$monitoring->id} status from {$monitoring->status} to " . ($status ?? '')  . ' as Risk Otorisator');
        }

        $monitoring->update(['status' => $status->value]);
        return $monitoring->histories()->create($history);
    }

    protected function residualRequestMapping(?array $data = []): array
    {
        return [
            'quarter' => (int) $data['quarter'],
            'impact_scale_id' => $data['impact_scale'] ?? null,
            'impact_probability_scale_id' => $data['impact_probability_scale'] ?? null,
            'impact_probability' => (int) $data['impact_probability'] ?? 0,
            'impact_value' => (float) $data['impact_value'] ?? 0,
            'risk_exposure' => (float) $data['risk_exposure'] ?? 0,
            'risk_level' => $data['risk_level'] ?? '',
            'risk_scale' => $data['risk_scale'] ?? '',
            'risk_mitigation_effectiveness' => string_to_bool($data['risk_mitigation_effectiveness']),
        ];
    }

    protected function actualizationRequestMapping(?array $data = []): array
    {
        return [
            'worksheet_mitigation_id' => $data['actualization_mitigation_id'] ?? null,
            'actualization_mitigation_plan' => purify($data['actualization_mitigation_plan'] ?? ''),
            'actualization_cost' => (float) $data['actualization_cost'] ?? 0,
            'actualization_cost_absorption' => (float) $data['actualization_cost_absorption'] ?? 0,
            'quarter' => (int) $data['quarter'] ?? '',
            'documents' => '',
            'kri_unit_id' => null,
            'kri_threshold' => strip_tags(purify($data['actualization_kri_threshold'] ?? '')),
            'kri_threshold_score' => strip_tags(purify($data['actualization_kri_threshold_score'] ?? '')),
            'actualization_plan_body' => purify($data['actualization_plan_body'] ?? ''),
            'actualization_plan_output' => purify($data['actualization_plan_output'] ?? ''),
            'actualization_plan_status' => strip_tags(purify($data['actualization_plan_status'] ?? '')),
            'actualization_plan_explanation' => purify($data['actualization_plan_explanation'] ?? ''),
            'actualization_plan_progress' => (float) $data['actualization_plan_progress'] ?? '',
            'unit_code' => strip_tags(purify($data['unit_code'] ?? '')),
            'unit_name' => strip_tags(purify($data['unit_name'] ?? '')),
            'personnel_area_code' => strip_tags(purify($data['personnel_area_code'] ?? '')),
            'position_name' => strip_tags(purify($data['position_name'] ?? '')),
        ];
    }

    protected function incidentRequestMapping(?array $data = []): array
    {
        return [
            'incident_body' => purify($data['incident_body'] ?? ''),
            'incident_identification' => purify($data['incident_identification'] ?? ''),
            'incident_category_id' => check_select_option_value($data['incident_category'] ?? ''),
            'incident_source' => check_select_option_value($data['incident_source'] ?? ''),
            'incident_cause' => purify($data['incident_cause'] ?? ''),
            'incident_handling' => purify($data['incident_handling'] ?? ''),
            'incident_description' => purify($data['incident_description'] ?? ''),
            'risk_category_t2_id' => check_select_option_value($data['risk_category_t2'] ?? ''),
            'risk_category_t3_id' => check_select_option_value($data['risk_category_t3'] ?? ''),
            'loss_description' => purify($data['loss_description'] ?? ''),
            'loss_value' => (float) ($data['loss_value'] ?? 0),
            'incident_repetitive' => string_to_bool($data['incident_repetitive'] ?? ''),
            'incident_frequency_id' => check_select_option_value($data['incident_frequency'] ?? ''),
            'mitigation_plan' => purify($data['mitigation_plan'] ?? ''),
            'actualization_plan' => purify($data['actualization_plan'] ?? ''),
            'follow_up_plan' => purify($data['follow_up_plan'] ?? ''),
            'related_party' => purify($data['related_party'] ?? ''),
            'insurance_status' => string_to_bool($data['insurance_status'] ?? ''),
            'insurance_permit' => (float) ($data['insurance_permit'] ?? 0),
            'insurance_claim' => (float) ($data['insurance_claim'] ?? 0),
        ];
    }
}
