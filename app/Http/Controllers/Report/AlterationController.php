<?php

namespace App\Http\Controllers\Report;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\Risk\WorksheetAlterationRequest;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetAlteration;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Mews\Purifier\Facades\Purifier;
use Yajra\DataTables\Facades\DataTables;

class AlterationController extends Controller
{
    public function __construct(
        private RoleService $roleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', new WorksheetAlteration());

        if (request()->ajax()) {
            $alterations = WorksheetAlteration::with(['worksheet', 'creator']);

            return DataTables::of($alterations)
                ->make(true);
        }

        return view('report.alteration.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', new WorksheetAlteration());
        return view('report.alteration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorksheetAlterationRequest $request)
    {
        Gate::authorize('create', new WorksheetAlteration());

        $alteration = $request->user()
            ->worksheet_alterations()
            ->create(
                collect($request->validated())->map(fn($v, $k) => $k == 'worksheet_id' ? $v : Purifier::clean($v))->toArray()
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
    public function update(Request $request, string $alteration)
    {
        $alteration = WorksheetAlteration::findByEncryptedIdOrFail($alteration);
        Gate::authorize('update', $alteration);

        $alteration->update(
            collect($request->validated())->map(fn($v, $k) => $k == 'worksheet_id' ? $v : Purifier::clean($v))->toArray()
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
        return '';
    }
}
