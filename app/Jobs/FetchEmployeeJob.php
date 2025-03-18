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
            DB::beginTransaction();


            foreach ($officials as $official) {
                $user = User::updateOrCreate(
                    ['employee_id' => $official->employee_id],
                    (array) $official
                );

                if ($user->wasRecentlyCreated) {
                    $created += 1;
                } else if ($user) {
                    $updated += 1;
                }

                $unit = UserUnit::create(
                    [
                        'user_id' => $user->id,
                        'source_type' => $sourceType,
                    ] + (array) $official
                );

                $headUnit = Position::whereSubUnitCode($official->sub_unit_code)
                    ->wherePositionName($official->position_name)
                    ->first();
                if ($unit) {
                    $unit->syncRoles($headUnit ? explode(',', $headUnit->assigned_roles) : ['risk admin']);
                }
            }

            foreach ($staffs as $staff) {
                $user = User::updateOrCreate(
                    ['employee_id' => $staff->employee_id],
                    (array) $staff
                );

                if ($user->wasRecentlyCreated) {
                    $created += 1;
                } else if ($user) {
                    $updated += 1;
                }

                $unit = UserUnit::create(
                    [
                        'user_id' => $user->id,
                        'source_type' => $sourceType,
                    ] + (array) $staff
                );

                $headUnit = Position::whereSubUnitCode($staff->sub_unit_code)
                    ->wherePositionName($staff->position_name)
                    ->first();
                if ($unit) {
                    $unit->syncRoles($headUnit ? explode(',', $headUnit->assigned_roles) : ['risk admin']);
                }
            }

            DB::commit();
            logger()->info("[FetchEmployeeJob] successfully fetched data number of created {$created} and updated {$updated}");
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[FetchEmployeeJob] ' . $e->getMessage(), [$e]);
        }
    }
}
