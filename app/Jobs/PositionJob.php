<?php

namespace App\Jobs;

use App\Models\Master\Position;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PositionJob
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $http = Http::withHeader('Authorization', env('EOFFICE_TOKEN'))
                ->asForm()
                ->post(env('EOFFICE_URL') . '/roles_get', ['effective_date' => '2025-01-06']);

            $created = 0;
            $updated = 0;
            if ($http->ok()) {
                $json = $http->json();
                foreach ($json['data'] as $item) {
                    if (!$item['UNIT_CODE']) {
                        continue;
                    }

                    foreach (array_keys($item) as $key) {
                        $_item[strtolower($key)] = $item[$key];
                    }

                    $position = Position::updateOrCreate(
                        [
                            'personnel_area_code' => $_item['personnel_area_code'],
                            'unit_code' => $_item['unit_code'],
                        ],
                        $_item
                    );

                    if ($position->wasRecentlyCreated) {
                        $created++;
                    } else {
                        $updated++;
                    }
                }
                logger("[Position Job] successfully fetched data number of created: $created, updated: $updated");
                Cache::put('master.positions', Position::all());
                Cache::put('master.position_pics', Position::distinct()->select('id', 'personnel_area_code', 'unit_code', 'unit_name', 'position_name')->get());

                Artisan::call('db:seed --class=PositionSeeder');
            }
        } catch (Exception $e) {
            logger()->error('[Position Job] ' . $e->getMessage());
        }
    }
}
