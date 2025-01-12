<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
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
            try {
                $http = Http::withHeader('Authorization', env('EOFFICE_TOKEN'))
                    ->asForm()
                    ->post(env('EOFFICE_URL') . '/roles_get', ['effective_date' => '2025-01-06']);

                if ($http->ok()) {
                    $json = $http->json();
                    foreach ($json['data'] as $item) {
                        foreach (array_keys($item) as $key) {
                            $_item[strtolower($key)] = $item[$key];
                        }

                        $data[] = $_item;
                    }

                    Cache::put('master.positions', $data, now()->addMinutes(5));
                }
            } catch (Exception $e) {
                return response()->json(['message' => 'gagal memuat data pic'], 500);
            }
        }

        return response()->json(['data' => $data]);
    }
}
