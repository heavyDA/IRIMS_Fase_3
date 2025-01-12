<?php

namespace App\Jobs;

use App\Models\Master\Position;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
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

            $positions = [];
            if ($http->ok()) {
                $json = $http->json();
                foreach ($json['data'] as $item) {
                    foreach (array_keys($item) as $key) {
                        $_item[strtolower($key)] = $item[$key];
                    }

                    $positions[] = $_item;
                }

                Position::upsert($positions, ['personnel_area_code', 'unit_code', 'unit_name', 'position_name']);
                logger('[Position Job] successfully cached data.');
                Cache::put('master.positions', $positions, now()->addMinutes(5));
            }
        } catch (Exception $e) {
            logger()->error('[Position Job] ' . $e->getMessage());
        }
    }
}
