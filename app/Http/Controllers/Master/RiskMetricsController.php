<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\RiskMetric;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Enums\State;
use Exception;
use Illuminate\Support\Facades\DB;

class RiskMetricsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $risk_metrics = RiskMetric::query();

            return DataTables::eloquent($risk_metrics)
                ->addColumn('action', function ($risk_metric) {
                    $actions = [
                        ['id' => $risk_metric->getEncryptedId(), 'route' => route('master.risk-metrics.show', $risk_metric->getEncryptedId()), 'type' => 'link', 'text' => 'detail', 'permission' => 'master.risk-metrics.detail'],
                        ['id' => $risk_metric->getEncryptedId(), 'route' => route('master.risk-metrics.edit', $risk_metric->getEncryptedId()), 'type' => 'link', 'text' => 'edit', 'permission' => 'master.risk-metrics.edit'],
                    ];

                    return view('layouts.partials._table_action', compact('actions'));
                })
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        try {
            $risk_metric = RiskMetric::whereOrganizationCode($request->organization_code)->first();
            if ($risk_metric) {
                $risk_metric->delete();
            }

            $risk_metric = RiskMetric::create($request->only(
                'organization_code',
                'personnel_area_code',
                'personnel_area_name',
                'capacity',
                'appetite',
                'tolerancy',
                'limit'
            ));

            DB::commit();
            return redirect()->route('master.risk-metrics.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Risk Metrics] Gagal menyimpan matrik strategi risiko. ' . $e->getMessage());
            return redirect()->back()->withInput($request->only(
                'organization_code',
                'personnel_area_code',
                'personnel_area_name',
                'capacity',
                'appetite',
                'tolerancy',
                'limit'
            ));
        }
    }

    public function delete(string $risk_metric)
    {
        if (RiskMetric::whereId(RiskMetric::decryptId($risk_metric))->delete()) {
            flash_message('flash_message', 'Berhasil menghapus matrik strategi risiko');
        } else {
            flash_message('flash_message', 'Gagal menghapus matrik strategi risiko', State::ERROR);
        }

        return redirect()->back();
    }
}
