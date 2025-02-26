<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\PositionRequest;
use App\Models\Master\Position;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $positions = Position::query();
            return DataTables::of($positions)
                ->addColumn('action', function ($position) {
                    $id = $position->getEncryptedId();
                    $actions = [
                        [
                            'type' => 'link',
                            'permission' => 'setting.positions.edit',
                            'text' => 'Edit',
                            'route' => route('setting.positions.edit', $id),
                        ],
                        [
                            'id' => $id,
                            'type' => 'delete',
                            'permission' => 'setting.positions.destroy',
                            'text' => 'Hapus',
                            'route' => route('setting.positions.destroy', $id),
                        ],
                    ];
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('setting.position.index');
    }

    public function create()
    {
        return view('setting.position.create');
    }

    public function store(PositionRequest $request)
    {
        Position::create($request->only('name'))
            ?
            flash_message('flash_message', 'Posisi berhasil ditambahkan')
            :
            flash_message('flash_message', 'Posisi gagal ditambahkan', State::ERROR);

        return redirect()->route('setting.positions.index');
    }

    public function edit(string $position)
    {
        $position = Position::findByEncryptedIdOrFail($position);
        return view('setting.position.edit', compact('position'));
    }

    public function update(string $position, PositionRequest $request)
    {
        $position = Position::findByEncryptedIdOrFail($position);

        $position->update(
            $request->only('name')
        ) ?
            flash_message('flash_message', 'Posisi berhasil diperbarui')
            :
            flash_message('flash_message', 'Posisi gagal diperbarui', State::ERROR);

        return redirect()->route('setting.positions.index');
    }

    public function destroy(string $position)
    {
        $position = Position::findByEncryptedIdOrFail($position);

        $position->delete() ?
            flash_message('flash_message', 'Posisi berhasil dihapus')
            :
            flash_message('flash_message', 'Posisi gagal dihapus', State::ERROR);

        return redirect()->route('setting.positions.index');
    }
}
