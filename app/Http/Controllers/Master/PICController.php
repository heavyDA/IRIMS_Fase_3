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
        $data = Cache::get('master.positions', []);

        if (empty($data)) {
            Cache::put('master.positions', Position::all(), now()->addMinutes(5));
        }

        return response()->json(['data' => $data]);
    }
}
