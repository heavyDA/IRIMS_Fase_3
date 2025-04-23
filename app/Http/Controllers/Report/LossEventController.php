<?php

namespace App\Http\Controllers\Report;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\Risk\WorksheetLossEventRequest;
use App\Models\Risk\WorksheetLossEvent;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Mews\Purifier\Facades\Purifier;

class LossEventController extends Controller
{
    public function __construct(
        private RoleService $roleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', new WorksheetLossEvent());
        return view('report.loss_event.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', new WorksheetLossEvent());
        return view('report.loss_event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorksheetLossEventRequest $request)
    {
        Gate::authorize('create', new WorksheetLossEvent());
        $lossEvent = WorksheetLossEvent::create(
            collect($request->validated())->map(fn($v, $k) => str_contains($k, '_id') ? $v : Purifier::clean($v))->toArray() +
                ['created_by' => auth()->user()->employee_id]
        );

        $lossEvent ?
            flash_message(message: 'Catatan Kejadian Kerugian berhasil disimpan') :
            flash_message(message: 'Gagal menyimpan Catatan Kejadian Kerugian', type: State::ERROR);

        return redirect()->route('risk.report.loss_event.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $lossEvent)
    {
        $lossEvent = WorksheetLossEvent::findByEncryptedIdOrFail($lossEvent);
        Gate::authorize('update', $lossEvent);

        $lossEvent->load('worksheet');

        return view('report.loss_event.edit', compact('alteration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $lossEvent)
    {
        $lossEvent = WorksheetLossEvent::findByEncryptedIdOrFail($lossEvent);
        Gate::authorize('update', $lossEvent);

        $lossEvent->update(
            collect($request->validated())->map(fn($v, $k) => $k == 'worksheet_id' ? $v : Purifier::clean($v))->toArray()
        ) ?
            flash_message(message: 'Catatan Kejadian Kerugian berhasil diperbarui') :
            flash_message(message: 'Gagal menyimpan pembaruan Catatan Kejadian Kerugian', type: State::ERROR);

        return redirect()->route('risk.report.loss_event.index');
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

        return redirect()->route('risk.report.loss_event.index');
    }

    public function export()
    {
        return '';
    }
}
