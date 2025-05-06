<?php

namespace App\Http\Controllers\Report;

use App\Enums\State;
use App\Exports\Risk\WorksheetLossEventExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Risk\WorksheetLossEventRequest;
use App\Models\Risk\WorksheetLossEvent;
use App\Services\PositionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LossEventController extends Controller
{
    public function __construct(
        private RoleService $roleService,
        private PositionService $positionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', new WorksheetLossEvent);
        if (request()->ajax()) {
            $unit = $this->roleService->getCurrentUnit();

            if (request()->has('unit') && !$this->roleService->isRiskAdmin()) {
                $unit = $this->positionService->getUnitBelow(
                    $unit?->sub_unit_code,
                    request('unit')
                ) ?: $unit;
            }

            $lossEvents = WorksheetLossEvent::getLossEvents($unit->sub_unit_code)
                ->whereYear('ra_worksheet_loss_events.created_at', request('year', date('Y')));

            return DataTables::query($lossEvents)->filter(function ($q) {
                $value = strip_html(purify(request('search.value')));

                if ($value) {
                    $value = "%{$value}%";
                    $q->where(
                        fn($q) => $q->orWhereLike('incident_body', $value)
                            ->orWhereLike('incident_date', $value)
                            ->orWhereLike('incident_source', $value)
                            ->orWhereLike('incident_handling', $value)
                            ->orWhereLike('risk_categories_t2.name', $value)
                            ->orWhereLike('risk_categories_t3.name', $value)
                            ->orWhereLike('loss_value', $value)
                            ->orWhereLike('related_party', $value)
                            ->orWhereLike('restoration_status', $value)
                            ->orWhereLike('insurance_status', $value)
                            ->orWhereLike('insurance_permit', $value)
                            ->orWhereLike('insurance_claim', $value)
                            ->orWhereLike('ra_worksheets.target_body', $value)
                            ->orWhereLike('ph.sub_unit_code_doc', $value)
                            ->orWhereLike('ph.sub_unit_name', $value)
                    );
                }
            })
                ->addColumn('action', function ($lossEvent) {
                    $id = Crypt::encryptString($lossEvent->id);

                    $actions = [];
                    if (Gate::allows('update', new WorksheetLossEvent(['id' => $lossEvent->id, 'created_by' => $lossEvent->created_by]))) {
                        $actions[] = ['id' => $id, 'route' => route('risk.report.loss_events.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (Gate::allows('delete', new WorksheetLossEvent(['id' => $lossEvent->id, 'created_by' => $lossEvent->created_by]))) {
                        $actions[] = ['id' => $id, 'route' => route('risk.report.loss_events.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->editColumn('incident_date', function ($lossEvent) {
                    return format_date($lossEvent->incident_date)->translatedFormat('d F Y H:i');
                })
                ->rawColumns([
                    'target_body',
                    'incident_body',
                    'incident_source',
                    'incident_handling',
                    'related_party',
                    'restoration_status',
                ])
                ->make(true);
        }
        return view('report.loss_event.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', new WorksheetLossEvent);
        return view('report.loss_event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorksheetLossEventRequest $request)
    {
        Gate::authorize('create', new WorksheetLossEvent);
        $data = [
            'worksheet_id' => $request->worksheet_id,
            'risk_category_t2_id' => $request->risk_category_t2_id,
            'risk_category_t3_id' => $request->risk_category_t3_id,
            'incident_date' => $request->incident_date,
            'incident_body' => purify($request->incident_body),
            'incident_source' => purify($request->incident_source),
            'incident_handling' => purify($request->incident_handling),
            'related_party' => purify($request->related_party),
            'restoration_status' => purify($request->restoration_status),
            'insurance_status' => $request->insurance_status,
            'insurance_permit' => $request->insurance_permit,
            'insurance_claim' => $request->insurance_claim,
            'created_by' => auth()->user()->employee_id
        ];

        $lossEvent = WorksheetLossEvent::create($data);
        $lossEvent ?
            flash_message(message: 'Catatan Kejadian Kerugian berhasil disimpan') :
            flash_message(message: 'Gagal menyimpan Catatan Kejadian Kerugian', type: State::ERROR);

        return redirect()->route('risk.report.loss_events.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $lossEvent)
    {
        $lossEvent = WorksheetLossEvent::findByEncryptedIdOrFail($lossEvent);
        Gate::authorize('update', $lossEvent);

        $lossEvent->load('worksheet');

        return view('report.loss_event.edit', compact('lossEvent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorksheetLossEventRequest $request, string $lossEvent)
    {
        $lossEvent = WorksheetLossEvent::findByEncryptedIdOrFail($lossEvent);
        Gate::authorize('update', $lossEvent);

        $lossEvent->update(
            collect($request->validated())->map(fn($v, $k) => in_array($k, ['worksheet_id', 'risk_category_t2_id', 'risk_category_t3_id', 'incident_date']) ? $v : purify($v))->toArray()
        ) ?
            flash_message(message: 'Catatan Kejadian Kerugian berhasil diperbarui') :
            flash_message(message: 'Gagal menyimpan pembaruan Catatan Kejadian Kerugian', type: State::ERROR);

        return redirect()->route('risk.report.loss_events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $lossEvent)
    {
        $lossEvent = WorksheetLossEvent::findByEncryptedIdOrFail($lossEvent);
        Gate::authorize('delete', $lossEvent);

        $lossEvent->delete() ?
            flash_message(message: 'Catatan Kejadian Kerugian berhasil dihapus') :
            flash_message(message: 'Gagal menghapus Catatan Kejadian Kerugian', type: State::ERROR);

        return redirect()->route('risk.report.loss_events.index');
    }

    public function export()
    {
        Gate::authorize('viewAny', new WorksheetLossEvent);
        $unit = $this->roleService->getCurrentUnit();

        if (request()->has('unit') && !$this->roleService->isRiskAdmin()) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit')
            ) ?: $unit;
        }

        $year = request('year', date('Y'));
        $value = '%' . strip_html(purify(request('search'))) . '%';
        $value = "%{$value}%";
        $lossEvents = WorksheetLossEvent::getLossEvents($unit->sub_unit_code)
            ->whereYear('ra_worksheet_loss_events.created_at', $year)
            ->when(
                fn($q) => $q->where(
                    fn($q) => $q->orWhereLike('incident_body', $value)
                        ->orWhereLike('incident_date', $value)
                        ->orWhereLike('incident_source', $value)
                        ->orWhereLike('incident_handling', $value)
                        ->orWhereLike('risk_categories_t2.name', $value)
                        ->orWhereLike('risk_categories_t3.name', $value)
                        ->orWhereLike('loss_value', $value)
                        ->orWhereLike('related_party', $value)
                        ->orWhereLike('restoration_status', $value)
                        ->orWhereLike('insurance_status', $value)
                        ->orWhereLike('insurance_permit', $value)
                        ->orWhereLike('insurance_claim', $value)
                        ->orWhereLike('ra_worksheets.target_body', $value)
                        ->orWhereLike('ph.sub_unit_code_doc', $value)
                        ->orWhereLike('ph.sub_unit_name', $value)
                )
            )
            ->orderBy('ra_worksheets.worksheet_number', 'asc')
            ->orderBy('ra_worksheet_loss_events.incident_date', 'asc')
            ->simplePaginate(request('per_page', 10));
        $lossEvents = collect($lossEvents->items());

        $date = now()->translatedFormat('d F Y');
        return Excel::download(new WorksheetLossEventExport($lossEvents), "Laporan Loss Event Database {$year} - {$date}.xlsx");
    }
}
