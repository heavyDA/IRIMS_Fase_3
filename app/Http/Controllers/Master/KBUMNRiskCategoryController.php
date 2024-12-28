<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\KBUMNRiskCategory;
use Illuminate\Http\Request;

class KBUMNRiskCategoryController extends Controller
{
    public function index()
    {
        $data = KBUMNRiskCategory::all();

        return response()->json(['data' => [
            'T2' => [...$data->filter(fn($item) => $item->type == 'T2')->toArray()],
            'T3' => [...$data->filter(fn($item) => $item->type == 'T3')->toArray()],
        ]]);
    }
}
