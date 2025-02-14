<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistingControlTypeRequest;
use App\Models\Master\ExistingControlType;
use Yajra\DataTables\Facades\DataTables;

class ExistingControlTypeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $existing_control_types = ExistingControlType::query();
            return DataTables::of($existing_control_types)
                ->addColumn('action', function ($existing_control_type) {
                    $id = $existing_control_type->getEncryptedId();
                    $actions = [
                        [
                            'type' => 'link',
                            'permission' => 'master.existing_control_types.edit',
                            'text' => 'Edit',
                            'route' => route('master.existing_control_types.edit', $id),
                        ],
                        [
                            'id' => $id,
                            'type' => 'delete',
                            'permission' => 'master.existing_control_types.destroy',
                            'text' => 'Hapus',
                            'route' => route('master.existing_control_types.destroy', $id),
                        ],
                    ];
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.existing_control_type.index');
    }

    public function create()
    {
        return view('master.existing_control_type.create');
    }

    public function store(ExistingControlTypeRequest $request)
    {
        ExistingControlType::create($request->only('type', 'name'))
            ?
            flash_message('flash_message', 'Jenis Existing Control berhasil diperbarui')
            :
            flash_message('flash_message', 'Jenis Existing Control gagal diperbarui', State::ERROR);

        return redirect()->route('master.existing_control_types.index');
    }

    public function edit(string $existing_control_type)
    {
        $existing_control_type = ExistingControlType::findByEncryptedIdOrFail($existing_control_type);
        return view('master.existing_control_type.edit', compact('existing_control_type'));
    }

    public function update(string $existing_control_type, ExistingControlTypeRequest $request)
    {
        $existing_control_type = ExistingControlType::findByEncryptedIdOrFail($existing_control_type);

        $existing_control_type->update(
            $request->only('type', 'name')
        ) ?
            flash_message('flash_message', 'Jenis Existing Control berhasil diperbarui')
            :
            flash_message('flash_message', 'Jenis Existing Control gagal diperbarui', State::ERROR);

        return redirect()->route('master.existing_control_types.index');
    }

    public function destroy(string $existing_control_type)
    {
        $existing_control_type = ExistingControlType::findByEncryptedIdOrFail($existing_control_type);

        $existing_control_type->delete() ?
            flash_message('flash_message', 'Jenis Existing Control berhasil dihapus')
            :
            flash_message('flash_message', 'Jenis Existing Control gagal dihapus', State::ERROR);

        return redirect()->route('master.existing_control_types.index');
    }


    public function get_all()
    {
        return response()->json(['data' => ExistingControlType::all()]);
    }
}
