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

class ProfileController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (Role::hasLookUpUnitHierarchy()) {
                $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
            } else {
                $unit = Role::getDefaultSubUnit();
            }

            $incidents = WorksheetIncident::incident_query_top_risk(str_replace('%', '', $unit))
                ->where('worksheet.status', 'approved')
                ->where('worksheet.sub_unit_code', 'like', $unit)
                ->where('worksheet.status', 'approved');


            return DataTables::query($incidents)
                ->editColumn('status', function ($incident) {
                    $status = DocumentStatus::tryFrom($incident->status);
                    $class = $status->color();
                    $worksheet_number = $incident->worksheet_number;
                    $route = route('risk.worksheet.show', Crypt::encryptString($incident->worksheet_id));

                    return view('risk.profile._table_status', compact('status', 'class', 'worksheet_number', 'route'))->render();
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $title = 'Risk Profile';

        return view('risk.profile.index', compact('title'));
    }

    public function store(Request $request)
    {
        if (Role::hasLookUpUnitHierarchy()) {
            $unit = request('unit') ? request('unit') . '%' : Role::getDefaultSubUnit();
        } else {
            $unit = Role::getDefaultSubUnit();
        }

        try {
            $worksheets = Worksheet::whereIn('id', $request->worksheets)->get();
            $unit = str_replace('%', '', $unit);

            DB::beginTransaction();
            WorksheetTopRisk::upsert(
                $worksheets->map(function ($worksheet) use ($unit) {
                    return [
                        'worksheet_id' => $worksheet->id,
                        'sub_unit_code' => $unit,
                        'source_sub_unit_code' => $worksheet->sub_unit_code,
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

    public function destroy(Request $request)
    {
        try {
            throw_if(
                !WorksheetTopRisk::where('id', $request->id)->delete(),
                new Exception('Worksheet Top Risk with ID ' . $request->id . ' tidak ditemukan')
            );
            return response()->json(
                ['message' => 'Berhasil menghapus top risk.'],
                200
            );
        } catch (Exception $e) {
            logger()->error('[Risk Profile] Gagal menghapus top risk. ' . $e->getMessage());
            return response()->json(
                ['message' => 'Gagal menghapus top risk.'],
                400
            );
        }
    }
}
