<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\RiskMetric;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Enums\State;
use App\Events\RiskMetricChanged;
use App\Models\Master\Position;
use Exception;
use Illuminate\Support\Facades\DB;

class RiskMetricsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $risk_metrics = RiskMetric::with('creator')
                ->when(request('with_history'), fn($q) => $q->withTrashed())
                ->orderBy('id', 'desc');

            return DataTables::eloquent($risk_metrics)
                ->filter(function ($q) {
                    $value = request('search.value');
                    if ($value) {
                        $q->where(
                            fn($q) => $q->whereLike('personnel_area_code', '%' . $value . '%')
                                ->orWhereLike('organization_name', '%' . $value . '%')
                        );
                    }
                })
                ->addColumn('status', function ($risk_metric) {
                    $badge = ['color' => State::SUCCESS, 'label' => 'Aktif'];
                    if ($risk_metric->deleted_at) {
                        $badge = ['color' => State::ERROR, 'label' => 'Tidak Aktif'];
                    }
                    return view('components.badge', $badge);
                })
                ->rawColumns(['state'])
                ->make(true);
        }

        return view('setting.risk_metric.index');
    }

    public function create()
    {
        $units = Position::hierarchyQuery('ap')
            ->where(
                fn($q) => $q->where('branch_code', 'PST')
                    ->orWhereLike('branch_code', 'REG%')
            )
            ->where('level', 1)
            ->get();
        return view('setting.risk_metric.create', compact('units'));
    }

    public function store(Request $request)
    {
        $position = Position::hierarchyQuery('ap')->where('sub_unit_code', $request->unit_code)->first();

        if (!$position) {

            flash_message('flash_message', 'Unit Kerja tidak ditemukan', State::ERROR);
            return back()->withInput();
        }

        try {
            $data = $request->only('capacity', 'appetite', 'tolerancy', 'limit');
            foreach ($data as $key => $value) {
                $value = str_replace(',', '.', str_replace('.', '', str_replace('Rp', '', $value)));

                if (is_numeric($value)) {
                    $data[$key] = $value;
                    continue;
                }
                flash_message('flash_message', 'Format ' . ucwords($key) . ' tidak valid', State::ERROR);
                return back()->withInput();
            }

            DB::beginTransaction();
            $risk_metric = RiskMetric::whereOrganizationCode($position->sub_unit_code)->first();
            if ($risk_metric) {
                $risk_metric->delete();
            }

            $risk_metric = RiskMetric::create(
                [
                    'organization_code' => $position->sub_unit_code,
                    'organization_name' => $position->sub_unit_name,
                    'personnel_area_code' => $position->branch_code,
                    'personnel_area_name' => '',
                    'year' => Date('Y'),
                    'created_by' => auth()->user()->id,
                ] + $data
            );

            DB::commit();

            RiskMetricChanged::dispatch($risk_metric);
            return redirect()->route('setting.risk_metrics.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Risk Metrics] Gagal menyimpan matrik strategi risiko. ' . $e->getMessage());
            flash_message('flash_message', 'Gagal menyimpan matrik strategi risiko', State::ERROR);

            return back()->withInput();
        }
    }
}
