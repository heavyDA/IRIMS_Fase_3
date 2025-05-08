<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Exports\Risk\WorksheetAlterationExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Risk\WorksheetAlterationRequest;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetAlteration;
use App\Services\PositionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Mews\Purifier\Facades\Purifier;
use Yajra\DataTables\Facades\DataTables;

class AlterationController extends Controller
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
        Gate::authorize('viewAny', new WorksheetAlteration);

        if (request()->ajax()) {
            $unit = $this->roleService->getCurrentUnit();

            if (request()->has('unit') && !$this->roleService->isRiskAdmin()) {
                $unit = $this->positionService->getUnitBelow(
                    $unit?->sub_unit_code,
                    request('unit')
                ) ?: $unit;
            }

            $alterations = WorksheetAlteration::getAlterations($unit->sub_unit_code)
                ->when(role()->isRiskAdmin(), fn($q) => $q->where('ra_worksheets.sub_unit_code', $unit->sub_unit_code))
                ->whereYear('ra_worksheet_alterations.created_at', request('year', date('Y')));

            return DataTables::query($alterations)
                ->filter(function ($q) {
                    $value = strip_html(purify(request('search.value')));

                    if ($value) {
                        $value = "%{$value}%";
                        $q->where(
                            fn($q) => $q->orWhereLike('body', $value)
                                ->orWhereLike('impact', $value)
                                ->orWhereLike('description', $value)
                                ->orWhereLike('ra_worksheets.target_body', $value)
                                ->orWhereLike('ph.sub_unit_code_doc', $value)
                                ->orWhereLike('ph.sub_unit_name', $value)
                        );
                    }
                })
                ->addColumn('action', function ($alteration) {
                    $id = Crypt::encryptString($alteration->id);
                    $actions = [];
                    if (Gate::allows('update', new WorksheetAlteration(['id' => $alteration->id, 'created_by' => $alteration->created_by]))) {
                        $actions[] = ['id' => $id, 'route' => route('risk.report.alterations.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (Gate::allows('delete', new WorksheetAlteration(['id' => $alteration->id, 'created_by' => $alteration->created_by]))) {
                        $actions[] = ['id' => $id, 'route' => route('risk.report.alterations.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->make(true);
        }

        return view('report.alteration.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', new WorksheetAlteration);
        return view('report.alteration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorksheetAlterationRequest $request)
    {
        Gate::authorize('create', new WorksheetAlteration);

        $alteration = $request->user()
            ->worksheet_alterations()
            ->create(
                collect($request->validated())->map(fn($v, $k) => $k == 'worksheet_id' ? $v : purify($v))->toArray()
            );

        $alteration ?
            flash_message(message: 'Perubahan Strategi Risiko berhasil disimpan') :
            flash_message(message: 'Gagal menyimpan Perubahan Strategi Risiko', type: State::ERROR);

        return redirect()->route('risk.report.alterations.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $alteration)
    {
        $alteration = WorksheetAlteration::findByEncryptedIdOrFail($alteration);
        Gate::authorize('update', $alteration);

        $alteration->load('worksheet');

        return view('report.alteration.edit', compact('alteration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorksheetAlterationRequest $request, string $alteration)
    {
        $alteration = WorksheetAlteration::findByEncryptedIdOrFail($alteration);
        Gate::authorize('update', $alteration);

        $alteration->update(
            collect($request->validated())->map(fn($v, $k) => $k == 'worksheet_id' ? $v : purify($v))->toArray()
        ) ?
            flash_message(message: 'Perubahan Strategi Risiko berhasil diperbarui') :
            flash_message(message: 'Gagal menyimpan pembaruan Perubahan Strategi Risiko', type: State::ERROR);

        return redirect()->route('risk.report.alterations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $alteration)
    {
        $alteration = WorksheetAlteration::findByEncryptedIdOrFail($alteration);
        Gate::authorize('delete', $alteration);

        $alteration->delete() ?
            flash_message(message: 'Perubahan Strategi Risiko berhasil dihapus') :
            flash_message(message: 'Gagal menghapus Perubahan Strategi Risiko', type: State::ERROR);

        return redirect()->route('risk.report.alterations.index');
    }

    public function export()
    {
        Gate::authorize('viewAny', new WorksheetAlteration);
        $unit = $this->roleService->getCurrentUnit();

        if (request()->has('unit') && !$this->roleService->isRiskAdmin()) {
            $unit = $this->positionService->getUnitBelow(
                $unit?->sub_unit_code,
                request('unit')
            ) ?: $unit;
        }

        $year = request('year', date('Y'));
        $value = '%' . strip_html(purify(request('search'))) . '%';
        $alterations = WorksheetAlteration::getAlterations($unit->sub_unit_code)
            ->when(role()->isRiskAdmin(), fn($q) => $q->where('ra_worksheets.sub_unit_code', $unit->sub_unit_code))
            ->whereYear('ra_worksheet_alterations.created_at', $year)
            ->when(
                $value,
                fn($q) => $q->where(
                    fn($q) => $q->whereLike('body', $value)
                        ->orWhereLike('impact', $value)
                        ->orWhereLike('description', $value)
                        ->orWhereLike('ra_worksheets.target_body', $value)
                        ->orWhereLike('ph.sub_unit_code_doc', $value)
                        ->orWhereLike('ph.sub_unit_name', $value)
                )
            )
            ->orderBy('ra_worksheets.worksheet_number', 'asc')
            ->orderBy('ra_worksheet_alterations.created_at', 'asc')
            ->simplePaginate(request('per_page', 10));
        $alterations = collect($alterations->items());

        $date = now()->translatedFormat('d F Y');
        return Excel::download(new WorksheetAlterationExport($alterations), "Laporan Ikhtisar Perubahan Profil Risiko {$year} - {$date}.xlsx");
    }
}
