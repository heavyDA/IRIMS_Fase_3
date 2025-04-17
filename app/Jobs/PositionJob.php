<?php

namespace App\Jobs;

use App\Enums\UnitSourceType;
use App\Models\Master\Position;
use App\Models\UserUnit;
use App\Services\EOffice\UnitService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PositionJob implements ShouldQueue
{
    use Queueable;

    protected UnitService $unitService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->unitService = new UnitService(config('app.eoffice.url'), config('app.eoffice.token'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $start = microtime(true);
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
                        $position->update(['assigned_roles' => 'risk admin']);
                        $created++;
                    } else {
                        if (empty($position->assigned_roles)) {
                            $position->update(['assigned_roles' => 'risk admin']);
                        }
                        $updated++;
                    }

                    $userUnits = UserUnit::where('sub_unit_code', $item->sub_unit_code)
                        ->where(fn($q) => $q->where('position_name', $item->position_name)->orWhere('position_name', "Pgs. {$item->position_name}"))
                        ->where('source_type', UnitSourceType::EOFFICE->value)
                        ->get();

                    if ($userUnits->isNotEmpty()) {
                        foreach ($userUnits as $userUnit) {
                            $userUnit->syncRoles(explode(',', $position->assigned_roles) ?? ['risk admin']);
                        }
                    }
                }

                DB::commit();
                logger()->info("[Position Job] successfully fetched data number of created: $created, updated: $updated in " . (microtime(true) - $start) . " seconds");
            }
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Position Job] ' . $e->getMessage() . " in " . (microtime(true) - $start) . " seconds");
        }
    }
}
