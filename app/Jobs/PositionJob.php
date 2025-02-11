<?php

namespace App\Jobs;

use App\Models\Master\Position;
use App\Services\EOffice\UnitService;
use Exception;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

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
                foreach ($data as $item) {
                    if (!$item->sub_unit_code) continue;

                    $position = Position::updateOrCreate(
                        [
                            'personnel_area_code' => $item->personnel_area_code,
                            'unit_code' => $item->sub_unit_code,
                        ],
                        [
                            'unit_code_doc' => $item->sub_unit_code_doc,
                            'unit_name' => $item->sub_unit_name,
                            'position_name' => $item->position_name,
                            'assigned_roles' => 'risk admin',
                        ]
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
