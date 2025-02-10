<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\Master\IncidentCategory;
use App\Models\Master\IncidentFrequency;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\Monitoring;
use App\Models\Risk\MonitoringHistory;
use App\Models\Risk\WorksheetIdentification;
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
    public function index()
    {
        if (request()->ajax()) {
            $unit = Role::getDefaultSubUnit();
            $worksheets = Worksheet::latest_monitoring_with_mitigation_query()
                ->whereLike('w.sub_unit_code', request('unit', $unit))
                ->when(request('document_status'), fn($q) => $q->where('w.status_monitoring', request('document_status')))
                ->when(
                    session()->get('current_role')?->name == 'risk admin',
                    fn($q) => $q->where('w.created_by', auth()->user()->employee_id)
                )
                ->where('worksheet_year', request('year', date('Y')));

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
                                ->orWhereLike('w.inherent_risk_level', '%' . $value . '%')
                                ->orWhereLike('w.inherent_risk_scale', '%' . $value . '%')
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
                ->rawColumns(['status_monitoring'])
                ->make(true);
        }

        $title = 'Risk Monitoring';
        return view('risk.process.index', compact('title'));
    }

    public function show(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $worksheet->identification = WorksheetIdentification::identification_query()->whereWorksheetId($worksheet->id)->firstOrFail();
        $worksheet->load('strategies', 'incidents.mitigations', 'monitorings');
        $title = 'Laporan Risk Monitoring';
        return view('risk.monitoring.index', compact('title', 'worksheet'));
    }

    public function create(string $worksheetId)
    {
        $worksheet = Worksheet::findByEncryptedIdOrFail($worksheetId);
        $worksheet->identification = WorksheetIdentification::identification_query()->whereWorksheetId($worksheet->id)->firstOrFail();
        if (request()->ajax()) {
            $worksheet->load('incidents.mitigations');

            $actualizations = [];
            $residuals = [];

            $actualizationsIndex = 0;
            $worksheet->incidents->each(function ($incident) use ($worksheet, &$actualizations, &$residuals, &$actualizationsIndex) {
                $quarter = ceil(date('m') / 3);
                $residuals[] = [
                    'incident_id' => $incident->id,
                    'period_date' => date('Y-m-d'),
                    'quarter' => $quarter,
                    'risk_cause_number' => $incident->risk_cause_number,
                    'risk_chronology_body' => $worksheet->identification->risk_chronology_body,
                    'risk_impact_category' => $worksheet->identification->risk_impact_category,
                    'risk_mitigation_effectiveness' => '',
                    'residual' => [],
                ];
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

            return response()->json([
                'data' => [
                    'inherent' => [
                        'risk_level' => $worksheet->identification->inherent_risk_level,
                        'risk_scale' => $worksheet->identification->inherent_risk_scale,
                    ],
                    'residuals' => $residuals,
                    'actualizations' => $actualizations
                ]
            ]);
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
                'period_date' => $request->residuals[0]['period_date'],
                'created_by' => $user->employee_id,
                'status' => DocumentStatus::DRAFT->value
            ]);

            $residuals = [];
            foreach ($request->residuals as $residual) {
                $_residual = [
                    'worksheet_incident_id' => $residual['incident_id'],
                    'quarter' => $residual['quarter'],
                    'risk_mitigation_effectiveness' => (bool) $residual['risk_mitigation_effectiveness'],
                ];

                if (array_key_exists('residual', $residual)) {
                    foreach ($residual['residual'] as $key => $item) {
                        if ($item) {
                            foreach ($item as $key => $value) {
                                if ($key == 'impact_scale' || $key == 'impact_probability_scale') {
                                    $_residual[$key . '_id'] = $value == 'Pilih' ? null : $value;
                                } else {
                                    $_residual[$key] = $value ?: '';
                                }
                            }
                            break;
                        }
                    }
                }
                $residuals[] = $_residual;
            }

            $monitoring->residuals()->createMany($residuals);

            $alteration = [];
            foreach ($request->alteration as $key => $value) {
                $alteration[str_replace('alteration_', '', $key)] = $value ?: '';
            }
            $monitoring->alteration()->create($alteration);

            $incident = [];
            foreach ($request->incident as $key => $value) {
                if (str_contains($key, 'category') || $key == 'incident_frequency') {
                    $incident[$key . '_id'] = $value == 'Pilih' ? null : $value;
                } else if ($key == 'incident_repetitive' || $key == 'insurance_status') {
                    $incident[$key] = $value == 'Pilih' ? null : $value != '0';
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
                    } else if ($key == 'actualization_mitigation_id') {
                        $actualization['worksheet_mitigation_id'] = $value ?: null;
                    } else {
                        $actualization[$key] = $value ?: '';
                    }
                }

                $actualizations[] = $actualization;
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
                    . $monitoring->period_date_format->translatedFormat('F')
                    . '/'
                    . $item['actualization_mitigation_id'];

                if (!Storage::disk('local')->exists($directory)) {
                    Storage::disk('local')->makeDirectory($directory);
                }

                $documents = [];
                if ($request->hasFile("actualizations.{$key}.actualization_documents")) {
                    $files = $request->actualizations[$key]['actualization_documents'];
                    if ($files) {
                        foreach ($files as $file) {
                            if ($file) {
                                $id = Str::uuid();

                                $file->storeAs($directory, $id . '.' . $file->getClientOriginalExtension());
                                $path = $directory . '/' . $id . '.' . $file->getClientOriginalExtension();

                                $documents[] = [
                                    'id' => $id,
                                    'name' => $file->getClientOriginalName(),
                                    'size' => $file->getSize(),
                                    'type' => $file->getClientOriginalExtension(),
                                    'url' => Crypt::encryptString(
                                        json_encode([
                                            'path' => $path,
                                            'filename' => $file->getClientOriginalName()
                                        ])
                                    )
                                ];
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
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error($e);

            return response()->json([
                'message' => 'Gagal menyimpan laporan monitoring',
            ], Response::HTTP_BAD_REQUEST);
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

        $monitoring->load([
            'residuals.impact_scale',
            'residuals.impact_probability_scale',
            'residuals.incident',
            'actualizations.mitigation.incident',
            'alteration',
            'incident',
            'histories',
            'last_history',
        ]);

        $worksheet->identification = WorksheetIdentification::identification_query()->whereWorksheetId($worksheet->id)->firstOrFail();

        $title = 'Risk Monitoring';
        return view('risk.monitoring.show', compact('title', 'worksheet', 'monitoring'));
    }

    public function edit_monitoring(string $monitoring_id)
    {
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        $monitoring->load([
            'residuals.impact_scale',
            'residuals.impact_probability_scale',
            'residuals.incident',
            'actualizations.mitigation.incident',
            'alteration',
            'incident',
            'histories',
            'last_history',
        ]);

        $worksheet = Worksheet::findOrFail($monitoring->worksheet_id);
        $worksheet->identification = WorksheetIdentification::identification_query()->whereWorksheetId($worksheet->id)->firstOrFail();

        if (request()->ajax()) {
            $actualizations = [];
            $residuals = [];

            $actualizationsIndex = 0;
            foreach ($monitoring->residuals as $index => $residual) {
                $values = [];
                for ($i = 0; $i <= 4; $i++) {
                    if ($i == $residual->quarter) {
                        $values[] =
                            [
                                'impact_probability' =>     $residual->impact_probability,
                                'impact_probability_scale' => $residual->impact_probability_scale_id ?? '',
                                'impact_scale' => $residual->impact_scale_id ?? '',
                                'impact_value' => $residual->impact_value,
                                'risk_exposure' => $residual->risk_exposure,
                                'risk_level' => $residual->risk_level,
                                'risk_scale' => $residual->risk_scale,
                            ];
                    } else {
                        $values[] = [];
                    }
                }

                $residuals[] = [
                    'key' => $index,
                    'id' => $residual->id,
                    'period_date' => $monitoring->period_date,
                    'incident_id' => $residual->incident->id,
                    'risk_cause_number' => $residual->incident->risk_cause_number,
                    'risk_chronology_body' => $worksheet->identification->risk_chronology_body,
                    'risk_impact_category' => $worksheet->identification->risk_impact_category,
                    'risk_mitigation_effectiveness' => $residual->risk_mitigation_effectiveness,
                    'quarter' => $residual->quarter,
                    "residual" => $values
                ];
            }

            foreach ($monitoring->actualizations as $index => $actualization) {
                $actualizations[] = [
                    'key' => $index,
                    'id' => $monitoring->actualizations[$index]->id,
                    'risk_cause_number' => $actualization->mitigation->incident->risk_cause_number,
                    'actualization_mitigation_id' => $actualization->mitigation->id,
                    'actualization_mitigation_plan' => $actualization->mitigation->mitigation_plan,
                    'actualization_cost' => $monitoring->actualizations[$index]->actualization_cost,
                    'actualization_cost_absorption' => $monitoring->actualizations[$index]->actualization_cost_absorption,
                    'quarter' => $monitoring->residuals[0]->quarter,
                    'actualization_documents' => $monitoring->actualizations[$index]->documents,
                    'actualization_kri' => $actualization->mitigation->incident->kri_body,
                    'actualization_kri_threshold' => $monitoring->actualizations[$index]->kri_threshold ?? '',
                    'actualization_kri_threshold_score' => $monitoring->actualizations[$index]->kri_threshold_score ?? '',
                    'actualization_plan_body' => $monitoring->actualizations[$index]->actualization_plan_body,
                    'actualization_plan_output' => $monitoring->actualizations[$index]->actualization_plan_output,
                    "actualization_plan_progress[{$monitoring->residuals[0]->quarter}]" => $monitoring->actualizations[$index]->actualization_plan_progress,
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

            return response()->json([
                'data' => [
                    'inherent' => [
                        'risk_level' => $worksheet->identification->inherent_risk_level,
                        'risk_scale' => $worksheet->identification->inherent_risk_scale,
                    ],
                    'residuals' => $residuals,
                    'actualizations' => $actualizations,
                    'alteration' => $alteration,
                    'incident' => $incident,
                ]
            ]);
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
        // $monitoring->load(['alteration', 'incident']);
        try {
            DB::beginTransaction();
            $monitoring->update(['period_date' => $request->residuals[0]['period_date']]);
            $residuals = [];
            $residuals_new  = [];
            foreach ($request->residuals as $residual) {
                $_residual = [
                    'worksheet_incident_id' => $residual['incident_id'],
                    'quarter' => $residual['quarter'],
                    'risk_mitigation_effectiveness' => (bool) $residual['risk_mitigation_effectiveness'],
                ];

                if (array_key_exists('residual', $residual)) {
                    foreach ($residual['residual'] as $key => $item) {
                        if ($item) {
                            foreach ($item as $key => $value) {
                                if ($key == 'impact_scale' || $key == 'impact_probability_scale') {
                                    $_residual[$key . '_id'] = $value == 'Pilih' ? null : $value;
                                } else {
                                    $_residual[$key] = $value ?: '';
                                }
                            }
                            break;
                        }
                    }
                }

                if ($residual['id']) {
                    $monitoring->residuals()->where('id', $residual['id'])->update($_residual);
                    $residuals[] = $_residual;
                } else {
                    $residuals_new[] = $_residual;
                }
            }

            $monitoring->residuals()->createMany($residuals_new);

            foreach ($request->alteration as $key => $value) {
                $alteration[str_replace('alteration_', '', $key)] = $value ?: '';
            }
            $monitoring->alteration()->update($alteration);

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
            $monitoring->incident()->update($incident);

            $actualizations = [];
            $actualizations_new = [];
            foreach ($request->actualizations as $actual) {
                $actualization = [];
                foreach ($actual as $key => $value) {
                    if (str_contains($key, 'kri')) {
                        $actualization[str_replace('actualization_', '', $key)] = $value ?: '';
                    } else if ($key == 'actualization_mitigation_id') {
                        $actualization['worksheet_mitigation_id'] = $value ?: null;
                    } else {
                        $actualization[$key] = $value ?: '';
                    }
                }

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
                    $monitoring->actualizations()->where('id', $actual['id'])->update($actualization);
                    $actualizations[] = $actualization;
                } else {
                    $actualizations_new[] = $actualization;
                }
            }

            $actualizations_new = $monitoring->actualizations()->createMany($actualizations_new)->toArray();

            foreach ($request->actualizations as $key => $item) {
                $directory = $user->sub_unit_code
                    . '/risk_monitoring/'
                    . $monitoring->period_date_format->translatedFormat('F')
                    . '/'
                    . $item['actualization_mitigation_id'];

                if (!Storage::disk('local')->exists($directory)) {
                    Storage::disk('local')->makeDirectory($directory);
                }

                $documents = [];
                if ($request->hasFile("actualizations.{$item['key']}.actualization_documents")) {
                    $files = $request->actualizations[$item['key']]['actualization_documents'];
                    if ($files) {
                        foreach ($files as $file) {
                            if (is_array($file)) {
                                $documents[] = $file;
                            } else if ($file) {
                                $id = Str::uuid();

                                $file->storeAs($directory, $id . '.' . $file->getClientOriginalExtension());
                                $path = $directory . '/' . $id . '.' . $file->getClientOriginalExtension();
                                $documents[] = [
                                    'id' => $id,
                                    'name' => $file->getClientOriginalName(),
                                    'size' => $file->getSize(),
                                    'type' => $file->getClientOriginalExtension(),
                                    'url' => Crypt::encryptString(
                                        json_encode([
                                            'path' => $path,
                                            'filename' => $file->getClientOriginalName()
                                        ])
                                    )
                                ];
                            }
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
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Worksheet Monitoring] Update Monitoring with ID ' . $monitoring->id . ' ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memperbarui laporan monitoring'], Response::HTTP_BAD_REQUEST);
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
            return redirect()->back();
        }
    }

    public function update_status_monitoring(string $monitoring_id, Request $request)
    {
        $monitoring = Monitoring::findByEncryptedIdOrFail($monitoring_id);
        $currentRole = session()->get('current_role');

        $rule = Str::snake($currentRole->name) . '_rule';

        try {
            DB::beginTransaction();
            $history = $this->$rule($monitoring, $request->status, $request->note);
            DB::commit();

            flash_message('flash_message', 'Laporan monitoring berhasil disubmit.', State::SUCCESS);
            return redirect()->route('risk.monitoring.show_monitoring', $monitoring_id);
        } catch (Exception $e) {
            DB::rollBack();
            flash_message('flash_message', $e->getMessage(), State::ERROR);
            return redirect()->route('risk.monitoring.show_monitoring', $monitoring_id);
        }
    }

    protected function risk_admin_rule(Monitoring $monitoring, string $status, string $note): MonitoringHistory
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

    protected function risk_owner_rule(Monitoring $monitoring, string $status, string $note): MonitoringHistory
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

    protected function risk_otorisator_rule(Monitoring $monitoring, string $status, string $note): MonitoringHistory
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
