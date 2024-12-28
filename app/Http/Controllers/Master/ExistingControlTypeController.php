<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\ExistingControlType;
use Illuminate\Http\Request;

class ExistingControlTypeController extends Controller
{
    public function index()
    {
        return response()->json(['data' => ExistingControlType::all()]);
    }
}
