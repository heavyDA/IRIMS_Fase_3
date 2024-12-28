<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\KRIUnit;
use Illuminate\Http\Request;

class KRIUnitController extends Controller
{
    public function index()
    {
        return response()->json(['data' => KRIUnit::all()]);
    }
}
