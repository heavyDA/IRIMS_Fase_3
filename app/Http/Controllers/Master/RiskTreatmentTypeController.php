<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\RiskTreatmentTypeRequest;
use App\Models\Master\RiskTreatmentType;
use Yajra\DataTables\Facades\DataTables;

class RiskTreatmentTypeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $risk_treatment_types = RiskTreatmentType::query();
            return DataTables::of($risk_treatment_types)
                ->addColumn('action', function($risk_treatment_type) {
                    $id = $risk_treatment_type->getEncryptedId();
                    $actions = [
                        [
                            'type' => 'link',
                            'permission' => 'master.risk_treatment_types.edit',
                            'text' => 'Edit',
                            'route' => route('master.risk_treatment_types.edit', $id),
                        ],
                        [
                            'id' => $id,
                            'type' => 'delete',
                            'permission' => 'master.risk_treatment_types.destroy',
                            'text' => 'Hapus',
                            'route' => route('master.risk_treatment_types.destroy', $id),
                        ],
                    ];
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.risk_treatment_type.index');
    }

    public function create()
    {
        return view('master.risk_treatment_type.create');
    }

    public function store(RiskTreatmentTypeRequest $request)
    {
        RiskTreatmentType::create($request->only('parent_id', 'number', 'name'))
        ?
        flash_message('flash_message', 'Opsi Perlakuan Risiko berhasil diperbarui')
        :
        flash_message('flash_message', 'Opsi Perlakuan Risiko gagal diperbarui', State::ERROR);

        return redirect()->route('master.risk_treatment_type.index');
    }

    public function edit(string $risk_treatment_type)
    {
        $risk_treatment_type = RiskTreatmentType::findByEncryptedIdOrFail($risk_treatment_type);
        return view('master.risk_treatment_type.edit', compact('scale'));
    }

    public function update(string $risk_treatment_type, RiskTreatmentTypeRequest $request)
    {
        $risk_treatment_type = RiskTreatmentType::findByEncryptedIdOrFail($risk_treatment_type);

        $risk_treatment_type->update(
            $request->only('parent_id', 'number', 'name')
        ) ?
        flash_message('flash_message', 'Opsi Perlakuan Risiko berhasil diperbarui')
        :
        flash_message('flash_message', 'Opsi Perlakuan Risiko gagal diperbarui', State::ERROR);

        return redirect()->route('master.risk_treatment_type.index');
    }
}
