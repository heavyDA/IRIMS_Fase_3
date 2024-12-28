<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Heatmap;
use Illuminate\Http\Request;

class HeatmapController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Heatmap::all()]);
    }
}
