<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Position;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PICController extends Controller
{
    public function index()
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
