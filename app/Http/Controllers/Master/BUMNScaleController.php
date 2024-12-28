<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BUMNScale;

class BUMNScaleController extends Controller
{
    public function index()
    {
        return response()->json(['data' => BUMNScale::all()]);
    }
}
