<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Position;

class PICController extends Controller
{
    public function get_all()
    {
        $data = cache()->remember(
            'master.position_pics',
            now()->addMinutes(5),
            function () {
                $units = Position::distinct()
                    ->select(
                        'sub_unit_code_doc as personnel_area_code',
                        'sub_unit_code as unit_code',
                        'sub_unit_name as unit_name',
                        'position_name',
                    )->get();

                return $units->isEmpty() ? null : $units;
            }
        );

        return response()->json(['data' => $data]);
    }
}
