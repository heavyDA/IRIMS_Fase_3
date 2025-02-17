<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Position;
use Illuminate\Support\Facades\Cache;

class PICController extends Controller
{
    public function get_all()
    {
        $data = Cache::get('master.position_pics', []);

        if (empty($data)) {
            Cache::put(
                'master.position_pics',
                Position::distinct()
                    ->select(
                        'id',
                        'personnel_area_code',
                        'unit_code',
                        'unit_name',
                        'position_name',
                    )->get()
            );
        }

        return response()->json(['data' => $data]);
    }
}
