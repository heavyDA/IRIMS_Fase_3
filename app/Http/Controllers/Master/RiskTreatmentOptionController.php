<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\RiskTreatmentOptionRequest;
use App\Models\Master\RiskTreatmentOption;
use Yajra\DataTables\Facades\DataTables;

class RiskTreatmentOptionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $risk_treatment_options = RiskTreatmentOption::query();
            return DataTables::of($risk_treatment_options)
                ->addColumn('action', function ($risk_treatment_option) {
                    $id = $risk_treatment_option->getEncryptedId();
                    $actions = [];
                    if (role()->checkPermission('master.risk_treatment_options.update')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_treatment_options.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (role()->checkPermission('master.risk_treatment_options.destroy')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_treatment_options.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }
                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.risk_treatment_option.index');
    }

    public function create()
    {
        return view('master.risk_treatment_option.create');
    }

    public function store(RiskTreatmentOptionRequest $request)
    {
        RiskTreatmentOption::create($request->only('name'))
            ?
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko berhasil ditambahkan')
            :
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko gagal ditambahkan', State::ERROR);

        return redirect()->route('master.risk_treatment_options.index');
    }

    public function edit(string $risk_treatment_option)
    {
        $risk_treatment_option = RiskTreatmentOption::findByEncryptedIdOrFail($risk_treatment_option);
        return view('master.risk_treatment_option.edit', compact('risk_treatment_option'));
    }

    public function update(string $risk_treatment_option, RiskTreatmentOptionRequest $request)
    {
        $risk_treatment_option = RiskTreatmentOption::findByEncryptedIdOrFail($risk_treatment_option);

        $risk_treatment_option->update(
            $request->only('name')
        ) ?
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko berhasil diperbarui')
            :
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko gagal diperbarui', State::ERROR);

        return redirect()->route('master.risk_treatment_options.index');
    }

    public function destroy(string $risk_treatment_option)
    {
        $risk_treatment_option = RiskTreatmentOption::findByEncryptedIdOrFail($risk_treatment_option);

        $risk_treatment_option->delete() ?
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko berhasil dihapus')
            :
            flash_message('flash_message', 'Jenis Rencana Perlakuan Risiko gagal dihapus', State::ERROR);

        return redirect()->route('master.risk_treatment_options.index');
    }
}
