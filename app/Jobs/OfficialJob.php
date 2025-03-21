<?php

namespace App\Jobs;

use App\Enums\UnitSourceType;
use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Models\User;
use App\Models\UserUnit;
use App\Services\EOffice\OfficialService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class OfficialJob implements ShouldQueue
{
    use Queueable;

    protected OfficialService $officialService;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->officialService = new OfficialService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
    }

    public function handle(): void
    {
        $start = microtime(true);
        try {
            $officials = $this->officialService->get_all();
            $created = 0;
            $updated = 0;

            if ($officials->isEmpty()) {
                throw new Exception('No data fetched');
            }

            DB::beginTransaction();
            foreach ($officials as $official) {
                $official = Official::updateOrCreate(
                    [
                        'employee_id' => $official->employee_id,
                        'sub_unit_code' => $official->sub_unit_code
                    ],
                    (array) $official
                );

                if ($official->wasRecentlyCreated) {
                    $created += 1;
                } else if ($official) {
                    $updated += 1;
                }

                $user = User::updateOrCreate([
                    'employee_id' => $official->employee_id
                ], (array) $official);

                $unit = UserUnit::updateOrCreate([
                    'user_id' => $user->id,
                    'source_type' => UnitSourceType::EOFFICE->value,
                    'sub_unit_code' => $official->sub_unit_code,
                    'position_name' => $official->position_name
                ], (array) $official);

                $position = Position::where('sub_unit_code', $official->sub_unit_code)
                    ->where('position_name', replace_pgs_from_position($official->position_name))
                    ->first();

                if ($position) {
                    $unit->syncRoles(explode(',', $position->assigned_roles) ?? ['risk admin']);
                } else {
                    $unit->syncRoles(['risk admin']);
                }
            }

            DB::commit();
            logger()->info("[Official Job] successfully fetched data number of created {$created} and updated {$updated} in " . (microtime(true) - $start) . " seconds");
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Official Job] ' . $e->getMessage() . " in " . (microtime(true) - $start) . " seconds");
        }
    }
}
