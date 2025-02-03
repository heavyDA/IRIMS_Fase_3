<?php

namespace App\Http\Controllers\Risk;

use App\Enums\DocumentStatus;
use App\Enums\State;
use App\Http\Controllers\Controller;
use App\Models\RBAC\Role;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIncident;
use App\Models\Risk\WorksheetTopRisk;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TopRiskController extends Controller
{
    public function index()
    {
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }

        if (request()->ajax()) {
            $level = Role::getLevel();
            if ($level < 2) {
                $worksheets = Worksheet::top_risk_upper_query(str_replace('.%', '%', $unit))
                    ->whereLike('wtr.sub_unit_code', str_replace('.%', '', $unit))
                    ->whereYear('w.created_at', request('year', date('Y')))
                    ->where('w.status', DocumentStatus::APPROVED->value);
            } else {
                $worksheets = Worksheet::top_risk_lower_query(str_replace('.%', '%', $unit))
                    ->whereLike('w.sub_unit_code', str_replace('.%', '%', $unit))
                    ->whereYear('w.created_at', request('year', date('Y')))
                    ->where('w.status', DocumentStatus::APPROVED->value);
            }

            return DataTables::query($worksheets)
                ->filter(function ($q) {
                    $value = request('search.value');

                    if ($value) {
                        $q->where(
                            fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                                ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                                ->orWhereLike('w.target_body', '%' . $value . '%')
                                ->orWhereLike('wi.risk_chronology_body', '%' . $value . '%')
                                ->orWhereLike('wi.risk_impact_body', '%' . $value . '%')
                                ->orWhereLike('winc.risk_cause_body', '%' . $value . '%')
                                ->orWhereLike('wi.inherent_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.inherent_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_1_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_2_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_3_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_4_risk_level', '%' . $value . '%')
                                ->orWhereLike('wi.residual_1_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_2_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_3_risk_scale', '%' . $value . '%')
                                ->orWhereLike('wi.residual_4_risk_scale', '%' . $value . '%')
                        );
                    }
                })
                ->editColumn('status', function ($worksheet) {
                    $status = DocumentStatus::tryFrom($worksheet->status);
                    $class = $status?->color() ?? 'info';
                    $worksheet_number = $worksheet->worksheet_number;
                    $route = route('risk.worksheet.show', Crypt::encryptString($worksheet->id));

                    return view('risk.top_risk._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
                })
                ->editColumn('top_risk_action', function ($worksheet) use ($unit, $level) {
                    if ($level < 2) {
                        if (
                            $worksheet->submit_source_sub_unit_code == str_replace('.%', '', $unit)
                        ) {
                            return '<button type="button" class="btn btn-sm btn-success"><i class="ti ti-check"></i></button>';
                        }
                    } else {
                        if (
                            $worksheet->source_sub_unit_code == str_replace('.%', '', $unit)
                        ) {
                            return '<button type="button" class="btn btn-sm btn-success"><i class="ti ti-check"></i></button>';
                        }
                    }


                    return '<input class="worksheet-selects" type="checkbox" name="worksheets[' . $worksheet->id . ']" value="' . $worksheet->id . '">';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $title = 'Top Risk';

        return view('risk.top_risk.index', compact('title'));
    }

    public function get_for_dashboard()
    {
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }
        $level = Role::getLevel();

        if ($level < 2) {
            $worksheets = Worksheet::top_risk_upper_dashboard_query(str_replace('.%', '%', $unit))
                ->whereLike('wtr.sub_unit_code', str_replace('.%', '', $unit))
                ->where('w.status', DocumentStatus::APPROVED->value)
                ->whereYear('w.created_at', request('year', date('Y')))
                ->groupBy('mr.id');
        } else {
            $worksheets = Worksheet::top_risk_lower_dashboard_query(str_replace('.%', '%', $unit))
                ->whereLike('w.sub_unit_code', str_replace('.%', '%', $unit))
                ->where('w.status', DocumentStatus::APPROVED->value)
                ->whereYear('w.created_at', request('year', date('Y')));
        }

        return DataTables::query($worksheets)
            ->filter(function ($q) {
                $value = request('search.value');

                if ($value) {
                    $q->where(
                        fn($q) => $q->orWhereLike('w.worksheet_number', '%' . $value . '%')
                            ->orWhereLike('w.sub_unit_name', '%' . $value . '%')
                            ->orWhereLike('w.target_body', '%' . $value . '%')
                            ->orWhereLike('wi.risk_chronology_body', '%' . $value . '%')
                            ->orWhereLike('wi.risk_impact_body', '%' . $value . '%')
                            ->orWhereLike('winc.risk_cause_body', '%' . $value . '%')
                            ->orWhereLike('wi.inherent_risk_level', '%' . $value . '%')
                            ->orWhereLike('wi.inherent_risk_scale', '%' . $value . '%')
                            ->orWhereLike('wi.residual_1_risk_level', '%' . $value . '%')
                            ->orWhereLike('wi.residual_2_risk_level', '%' . $value . '%')
                            ->orWhereLike('wi.residual_3_risk_level', '%' . $value . '%')
                            ->orWhereLike('wi.residual_4_risk_level', '%' . $value . '%')
                            ->orWhereLike('wi.residual_1_risk_scale', '%' . $value . '%')
                            ->orWhereLike('wi.residual_2_risk_scale', '%' . $value . '%')
                            ->orWhereLike('wi.residual_3_risk_scale', '%' . $value . '%')
                            ->orWhereLike('wi.residual_4_risk_scale', '%' . $value . '%')
                    );
                }
            })
            ->editColumn('status', function ($worksheet) {
                $status = DocumentStatus::tryFrom($worksheet->status);
                $class = $status?->color() ?? 'info';
                $worksheet_number = $worksheet->worksheet_number;
                $route = route('risk.worksheet.show', Crypt::encryptString($worksheet->id));

                return view('risk.top_risk._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
            })
            ->editColumn('top_risk_action', function ($worksheet) use ($unit, $level) {
                if ($level < 2) {
                    if (
                        $worksheet->submit_source_sub_unit_code == str_replace('%', '', $unit)
                    ) {
                        return '<button type="button" class="btn btn-sm btn-success"><i class="ti ti-check"></i></button>';
                    }
                } else {
                    if (
                        $worksheet->source_sub_unit_code == str_replace('%', '', $unit)
                    ) {
                        return '<button type="button" class="btn btn-sm btn-success"><i class="ti ti-check"></i></button>';
                    }
                }


                return '<input class="worksheet-selects" type="checkbox" name="worksheets[' . $worksheet->id . ']" value="' . $worksheet->id . '">';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $worksheets = Worksheet::whereIn('id', $request->worksheets)->get();

            DB::beginTransaction();
            WorksheetTopRisk::upsert(
                $worksheets->map(function ($worksheet) {
                    $user = auth()->user();

                    return [
                        'worksheet_id' => $worksheet->id,
                        'sub_unit_code' => $user->sub_unit_code == 'ap' ? '' : $user->unit_code,
                        'source_sub_unit_code' => $user->sub_unit_code,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray(),
                ['worksheet_id', 'sub_unit_code', 'source_sub_unit_code']
            );
            DB::commit();
            return response()->json(
                ['message' => 'Berhasil submit top risk.'],
                200
            );
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Risk Profile] Gagal menyimpan top risk. ' . $e->getMessage());
            return response()->json(
                ['message' => 'Gagal submit top risk.'],
                400
            );
        }
    }
}
