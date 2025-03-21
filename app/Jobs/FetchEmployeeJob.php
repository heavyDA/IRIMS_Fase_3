<?php

namespace App\Jobs;

use App\Enums\UnitSourceType;
use App\Models\Master\Position;
use App\Models\User;
use App\Models\UserUnit;
use App\Services\EOffice\OfficialService;
use App\Services\EOffice\StaffService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class FetchEmployeeJob implements ShouldQueue
{
    use Queueable;

    protected OfficialService $officialService;
    protected StaffService $staffService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->staffService = new StaffService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
        $this->officialService = new OfficialService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
        // $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $start = microtime(true);
        try {
            $officials = $this->officialService->get_all();
            if ($officials->isEmpty()) {
                logger()->info(['FetchEmployeeJob' => 'No officials data fetched']);
            }

            $staffs = $this->staffService->get_all();
            $created = 0;
            $updated = 0;

            if ($staffs->isEmpty()) {
                logger()->info(['FetchEmployeeJob' => 'No staffs data fetched']);
            }

            if ($officials->isEmpty() && $staffs->isEmpty()) {
                logger()->info(['FetchEmployeeJob' => 'Finished without proceeding data.']);
                return;
            }

            $sourceType = UnitSourceType::EOFFICE->value;
            $users = [];

            DB::beginTransaction();


            foreach ($officials as $official) {
                $user = User::updateOrCreate(
                    ['employee_id' => $official->employee_id],
                    (array) $official
                );

                if ($user->wasRecentlyCreated) {
                    $created += 1;
                } else {
                    $updated += 1;
                }

                $unit = UserUnit::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'source_type' => $sourceType,
                        'sub_unit_code' => $official->sub_unit_code,
                        'position_name' => $official->position_name,
                    ],
                    (array) $official
                );

                $headUnit = Position::whereSubUnitCode($official->sub_unit_code)
                    ->wherePositionName($official->position_name)
                    ->first();
                if ($unit) {
                    $unit->syncRoles($headUnit ? explode(',', $headUnit->assigned_roles) : ['risk admin']);
                }

                if (array_key_exists($user->id, $users)) {
                    $users[$user->id] = [$unit->id];
                } else {
                    $users[$user->id][] = $unit->id;
                }
            }

            foreach ($staffs as $staff) {
                $user = User::updateOrCreate(
                    ['employee_id' => $staff->employee_id],
                    (array) $staff
                );

                if ($user->wasRecentlyCreated) {
                    $created += 1;
                } else {
                    $updated += 1;
                }

                $unit = UserUnit::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'source_type' => $sourceType,
                        'sub_unit_code' => $staff->sub_unit_code,
                        'position_name' => $staff->position_name,
                    ],
                    (array) $staff
                );

                $headUnit = Position::whereSubUnitCode($staff->sub_unit_code)
                    ->wherePositionName($staff->position_name)
                    ->first();
                if ($unit) {
                    $unit->syncRoles($headUnit ? explode(',', $headUnit->assigned_roles) : ['risk admin']);
                }

                if (array_key_exists($user->id, $users)) {
                    $users[$user->id][] = $unit->id;
                } else {
                    $users[$user->id] = [$unit->id];
                }
            }

            foreach ($users as $userId => $units) {
                $inactiveUnits = UserUnit::where('user_id', $userId)->whereNotIn('id', $units)->get();
                foreach ($inactiveUnits as $inactiveUnit) {
                    $inactiveUnit->delete();
                }
            }

            DB::commit();
            logger()->info("[FetchEmployeeJob] successfully fetched data number of created {$created} and updated {$updated} in " . (microtime(true) - $start) . " seconds");
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[FetchEmployeeJob] ' . $e->getMessage() . " in " . (microtime(true) - $start) . " seconds", [$e]);
        }
    }
}
