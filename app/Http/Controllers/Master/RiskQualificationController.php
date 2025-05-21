<?php

namespace App\Http\Controllers\Master;

use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RiskQualificationRequest;
use App\Models\Master\RiskQualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class RiskQualificationController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $riskQualifications = RiskQualification::with('creator');

            return DataTables::of($riskQualifications)
                ->addIndexColumn()
                ->addColumn('action', function ($riskQualification) {
                    $id = Crypt::encryptString($riskQualification->id);

                    $actions = [];
                    if (role()->checkPermission('master.risk_qualifications.update')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_qualifications.edit', $id), 'type' => 'link', 'text' => 'edit', 'permission' => true];
                    }
                    if (role()->checkPermission('master.risk_qualifications.destroy')) {
                        $actions[] = ['id' => $id, 'route' => route('master.risk_qualifications.destroy', $id), 'type' => 'delete', 'text' => 'hapus', 'permission' => true];
                    }

                    if (empty($actions)) {
                        return '';
                    }

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.risk_qualification.index');
    }

    public function create()
    {
        return view('master.risk_qualification.create');
    }

    public function store(RiskQualificationRequest $request)
    {
        if (RiskQualification::create($request->validated() + ['created_by' => auth()->user()->employee_id])) {
            flash_message('success', 'Kualifikasi Risiko berhasil ditambahkan');
        } else {
            flash_message('error', 'Kualifikasi Risiko gagal ditambahkan', State::ERROR);
        }

        return redirect()->route('master.risk_qualifications.index');
    }

    public function edit(string $riskQualification)
    {
        $riskQualification = RiskQualification::findByEncryptedIdOrFail($riskQualification);
        return view('master.risk_qualification.edit', compact('riskQualification'));
    }

    public function update(RiskQualificationRequest $request, string $riskQualification)
    {
        $riskQualification = RiskQualification::findByEncryptedIdOrFail($riskQualification);

        if ($riskQualification->update($request->validated() + ['created_by' => auth()->user()->employee_id])) {
            flash_message('success', 'Kualifikasi Risiko berhasil diperbarui');
        } else {
            flash_message('error', 'Kualifikasi Risiko gagal diperbarui', State::ERROR);
        }

        return redirect()->route('master.risk_qualifications.index');
    }

    public function destroy(string $riskQualification)
    {
        $riskQualification = RiskQualification::findByEncryptedIdOrFail($riskQualification);
        if ($riskQualification->delete()) {
            flash_message('success', 'Kualifikasi Risiko berhasil dihapus');
        } else {
            flash_message('error', 'Kualifikasi Risiko gagal dihapus', State::ERROR);
        }

        return redirect()->route('master.risk_qualifications.index');
    }
}
