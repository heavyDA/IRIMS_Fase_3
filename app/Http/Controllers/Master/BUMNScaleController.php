<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\BUMNScaleRequest;
use App\Models\Master\BUMNScale;
use Yajra\DataTables\Facades\DataTables;

class BUMNScaleController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $bumn_scales = BUMNScale::query();
            return DataTables::of($bumn_scales)
                ->addColumn('action', function($bumn_scale) {
                    $id = $bumn_scale->getEncryptedId();
                    $actions = [
                        [
                            'type' => 'link',
                            'permission' => 'master.bumn_scales.edit',
                            'text' => 'Edit',
                            'route' => route('master.bumn_scales.edit', $id),
                        ],
                        [
                            'id' => $id,
                            'type' => 'delete',
                            'permission' => 'master.bumn_scales.destroy',
                            'text' => 'Hapus',
                            'route' => route('master.bumn_scales.destroy', $id),
                        ],
                    ];
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.bumn_scale.index');
    }

    public function create()
    {
        return view('master.bumn_scale.create');
    }

    public function store(BUMNScaleRequest $request)
    {
        BUMNScale::create($request->only('impact_category', 'scale', 'criteria', 'description', 'min', 'max'))
        ?
        flash_message('flash_message', 'Skala berhasil ditambahkan')
        :
        flash_message('flash_message', 'Skala gagal ditambahkan', State::ERROR);

        return redirect()->route('master.bumn_scales.index');
    }

    public function edit(string $bumn_scale_id)
    {
        $bumn_scale = BUMNScale::findByEncryptedIdOrFail($bumn_scale_id);
        return view('master.bumn_scale.edit', compact('bumn_scale', 'bumn_scale_id'));
    }

    public function update(string $bumn_scale, BUMNScaleRequest $request)
    {
        $bumn_scale = BUMNScale::findByEncryptedIdOrFail($bumn_scale);

        $bumn_scale->update(
            $request->only('impact_category', 'scale', 'criteria', 'description', 'min', 'max')
        ) ?
        flash_message('flash_message', 'Skala berhasil diperbarui')
        :
        flash_message('flash_message', 'Skala gagal diperbarui', State::ERROR);

        return redirect()->route('master.bumn_scales.index');
    }

    public function destroy(string $bumn_scale)
    {
        $bumn_scale = BUMNScale::findByEncryptedIdOrFail($bumn_scale);

        $bumn_scale->delete() ?
        flash_message('flash_message', 'Skala berhasil dihapus')
        :
        flash_message('flash_message', 'Skala gagal dihapus', State::ERROR);

        return redirect()->route('master.bumn_scales.index');
    }

    public function get_all()
    {
        return response()->json(['data' => BUMNScale::all()]);
    }
}
