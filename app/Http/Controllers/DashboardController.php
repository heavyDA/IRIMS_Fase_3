<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Master\Heatmap;

class DashboardController extends Controller
{
    public function getheatmap()
    {
        return response()->json(['data' => Heatmap::all()]);
    }
}
