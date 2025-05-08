<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\KRIUnitRequest;
use App\Models\Master\KRIUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class KRIUnitController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $units = KRIUnit::with('creator');

            return DataTables::of($units)
                ->addIndexColumn()
                ->addColumn('action', function ($unit) {
                    $id = Crypt::encryptString($unit->id);

                    $actions = [];
                    if (role()->checkPermission('master.kri_units.update')) {
                        $actions[] = ['id' => $id, 'route' => route('master.kri_units.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (role()->checkPermission('master.kri_units.destroy')) {
                        $actions[] = ['id' => $id, 'route' => route('master.kri_units.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.kri_unit.index');
    }

    public function create()
    {
        return view('master.kri_unit.create');
    }

    public function store(KRIUnitRequest $request)
    {
        if (KRIUnit::create($request->validated())) {
            flash_message('success', 'KRI Unit berhasil ditambahkan');
        } else {
            flash_message('error', 'KRI Unit gagal ditambahkan', State::ERROR);
        }

        return redirect()->route('master.kri_units.index');
    }

    public function edit(string $kriUnit)
    {
        $kriUnit = KRIUnit::findByEncryptedIdOrFail($kriUnit);
        return view('master.kri_unit.edit', compact('kriUnit'));
    }

    public function update(KRIUnitRequest $request, string $kriUnit)
    {
        $kriUnit = KRIUnit::findByEncryptedIdOrFail($kriUnit);

        if ($kriUnit->update($request->validated() + ['created_by' => auth()->user()->employee_id])) {
            flash_message('success', 'KRI Unit berhasil diperbarui');
        } else {
            flash_message('error', 'KRI Unit gagal diperbarui', State::ERROR);
        }

        return redirect()->route('master.kri_units.index');
    }

    public function destroy(string $kriUnit)
    {
        $kriUnit = KRIUnit::findByEncryptedIdOrFail($kriUnit);
        if ($kriUnit->delete()) {
            flash_message('success', 'KRI Unit berhasil dihapus');
        } else {
            flash_message('error', 'KRI Unit gagal dihapus', State::ERROR);
        }

        return redirect()->route('master.kri_units.index');
    }
}
