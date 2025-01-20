<?php

namespace App\Jobs;

use App\Models\Master\Official;
use Exception;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OfficialJob
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        try {
            $http = Http::withHeader('Authorization', env('EOFFICE_TOKEN'))
                ->asForm()
                ->post(env('EOFFICE_URL') . '/pejabat_get', ['effective_date' => '2025-01-06']);

            if ($http->ok()) {
                $officials = [];
                DB::table('m_officials')->truncate();
                $json = $http->json();
                foreach ($json['data'] as $item) {
                    $_item = [];

                    if (!$item['UNIT_CODE']) {
                        continue;
                    }

                    foreach (array_keys($item) as $key) {
                        $_item[strtolower($key)] = $item[$key];
                    }

                    $officials[] = $_item;
                }

                DB::beginTransaction();
                Official::insert($officials);
                DB::commit();

                Cache::put('master.officials', Official::all());
                Cache::put('master.units', Official::getSubUnitOnly()->get());

                logger("[Official Job] successfully fetched data number of fetched " . $json['totalData']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Official Job] ' . $e->getMessage());
        }
    }
}
