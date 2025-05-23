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
                ->addColumn('action', function ($risk_treatment_type) {
                    $id = $risk_treatment_type->getEncryptedId();
                    $actions = [];
                    if (role()->checkPermission('master.risk_treatment_types.update')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_treatment_types.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (role()->checkPermission('master.risk_treatment_types.destroy')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_treatment_types.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }
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
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko berhasil ditambahkan')
            :
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko gagal ditambahkan', State::ERROR);

        return redirect()->route('master.risk_treatment_types.index');
    }

    public function edit(string $risk_treatment_type)
    {
        $risk_treatment_type = RiskTreatmentType::findByEncryptedIdOrFail($risk_treatment_type);
        return view('master.risk_treatment_type.edit', compact('risk_treatment_type'));
    }

    public function update(string $risk_treatment_type, RiskTreatmentTypeRequest $request)
    {
        $risk_treatment_type = RiskTreatmentType::findByEncryptedIdOrFail($risk_treatment_type);

        $risk_treatment_type->update(
            $request->only('parent_id', 'number', 'name')
        ) ?
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko berhasil diperbarui')
            :
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko gagal diperbarui', State::ERROR);

        return redirect()->route('master.risk_treatment_types.index');
    }

    public function destroy(string $risk_treatment_type)
    {
        $risk_treatment_type = RiskTreatmentType::findByEncryptedIdOrFail($risk_treatment_type);

        $risk_treatment_type->delete() ?
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko berhasil dihapus')
            :
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko gagal dihapus', State::ERROR);

        return redirect()->route('master.risk_treatment_types.index');
    }
}
