<?php

namespace App\Jobs;

use App\Models\Master\Position;
use App\Services\EOffice\UnitService;
use Exception;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PositionJob
{
    use Queueable;

    protected UnitService $unitService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->unitService = new UnitService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $data = $this->unitService->get_all();

            $created = 0;
            $updated = 0;
            if ($data->isNotEmpty()) {
                DB::beginTransaction();
                foreach ($data as $item) {
                    $position = Position::updateOrCreate(
                        [
                            'sub_unit_code' => $item->sub_unit_code
                        ],
                        (array) $item
                    );

                    if ($position->wasRecentlyCreated) {
                        $created++;
                    } else {
                        $updated++;
                    }
                }

                logger("[Position Job] successfully fetched data number of created: $created, updated: $updated");
                Cache::put('master.positions', Position::all());
                DB::commit();

                Artisan::call('db:seed --class=PositionSeeder');
            }
        } catch (Exception $e) {
            logger()->error('[Position Job] ' . $e->getMessage());
        }
    }
}
