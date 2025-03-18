<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\RiskMetric;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Enums\State;
use App\Events\RiskMetricChanged;
use App\Models\Master\Position;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class RiskMetricsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $riskMetrics = RiskMetric::with('creator')
                ->when(in_array(request('with_history'), ['1', 1]), fn($q) => $q->withTrashed())
                ->when(request('unit'), fn($q) => $q->where('organization_code', request('unit')))
                ->orderBy('id', 'desc');

            return DataTables::eloquent($riskMetrics)
                ->filter(function ($q) {
                    $value = request('search.value');
                    if ($value) {
                        $q->where(
                            fn($q) => $q->whereLike('personnel_area_code', '%' . $value . '%')
                                ->orWhereLike('organization_name', '%' . $value . '%')
                                ->orWhere('capacity', '>=', $value)
                                ->orWhere('appetite', '>=', $value)
                                ->orWhere('tolerancy', '>=', $value)
                                ->orWhere('limit', '>=', $value)
                                ->orWhereHas('creator', fn($q) => $q->whereLike('username', '%' . $value . '%')->whereLike('employee_name', '%' . $value . '%'))
                        );
                    }
                })
                ->addColumn('status', function ($riskMetric) {
                    $badge = ['color' => State::SUCCESS, 'label' => 'Aktif'];
                    if ($riskMetric->deleted_at) {
                        $badge = ['color' => State::ERROR, 'label' => 'Tidak Aktif'];
                    }
                    return view('components.badge', $badge);
                })
                ->editColumn('created_at', function ($riskMetric) {
                    return Carbon::parse($riskMetric->created_at)->translatedFormat('d F Y H:i');
                })
                ->orderColumn('organization_code', 'organization_name $1')
                ->orderColumn('capacity', 'capacity $1')
                ->orderColumn('appetite', 'appetite $1')
                ->orderColumn('tolerancy', 'tolerancy $1')
                ->orderColumn('limit', 'limit $1')
                ->orderColumn('created_by', 'created_by $1')
                ->orderColumn('deleted_at', 'deleted_at $1')
                ->orderColumn('created_at', 'created_at $1')
                ->rawColumns(['state'])
                ->make(true);
        }

        $years = RiskMetric::select('year')->distinct()->get() ?? collect(['year' => date('Y')]);
        $units = $this->getLevelOneUnit();

        return view('setting.risk_metric.index', compact('years', 'units'));
    }

    public function create()
    {
        $units = $this->getLevelOneUnit();
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
            $riskMetric = RiskMetric::whereOrganizationCode($position->sub_unit_code)->first();
            if ($riskMetric) {
                $riskMetric->delete();
            }

            $riskMetric = RiskMetric::create(
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

            RiskMetricChanged::dispatch($riskMetric);
            return redirect()->route('setting.risk_metrics.index');
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Risk Metrics] Gagal menyimpan matrik strategi risiko. ' . $e->getMessage());
            flash_message('flash_message', 'Gagal menyimpan matrik strategi risiko', State::ERROR);

            return back()->withInput();
        }
    }

    protected function getLevelOneUnit()
    {
        return Position::hierarchyQuery('ap')
            ->where(
                fn($q) => $q->where('branch_code', 'PST')
                    ->orWhereLike('branch_code', 'REG%')
            )
            ->where('level', 1)
            ->get();
    }
}
