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
                $headUnit = Position::where('sub_unit_code', $official->sub_unit_code)
                    ->first();

                if (!$headUnit) {
                    logger()->debug("[FetchEmployeeJob] Position [{$official->sub_unit_code}] {$official->sub_unit_name} not found from Employee [$official->employee_id] {$official->employee_name}", ['data' => $official]);
                    continue;
                }

                $user = User::updateOrCreate(
                    ['employee_id' => $official->employee_id],
                    (array) $official
                );

                if ($user->wasRecentlyCreated) {
                    $created += 1;
                } else {
                    $updated += 1;
                }

                $unit = $user->units()->updateOrCreate(
                    [
                        'source_type' => $sourceType,
                        'sub_unit_code' => $official->sub_unit_code,
                        'position_name' => $official->position_name,
                    ],
                    [
                        'branch_code' => $headUnit->branch_code,
                        'unit_code' => $headUnit->unit_code,
                        'unit_code_doc' => $headUnit->unit_code_doc,
                        'unit_name' => $headUnit->unit_name,
                        'sub_unit_code_doc' => $headUnit->sub_unit_code_doc,
                        'sub_unit_name' => $headUnit->sub_unit_name,
                        'organization_code' => $headUnit->sub_unit_code,
                        'organization_name' => $headUnit->sub_unit_name,
                        'personnel_area_code' => $official->personnel_area_code,
                        'personnel_area_name' => $official->personnel_area_name,
                        'employee_grade_code' => $official->employee_grade_code,
                        'employee_grade' => $official->employee_grade,
                        'source_type' => $sourceType,
                    ]
                );

                if ($unit) {
                    $unit->syncRoles(
                        $headUnit->position_name == replace_pgs_from_position($official->position_name) ?
                            (explode(',', $headUnit->assigned_roles) ?? ['risk admin']) : ['risk admin']
                    );
                }

                if (array_key_exists($user->id, $users)) {
                    $users[$user->id] = [$unit->id];
                } else {
                    $users[$user->id][] = $unit->id;
                }
            }

            foreach ($staffs as $staff) {
                $headUnit = Position::where('sub_unit_code', $staff->sub_unit_code)
                    ->first();

                if (!$headUnit) {
                    logger()->debug("[FetchEmployeeJob] Position [{$staff->sub_unit_code}] {$staff->sub_unit_name} not found from Employee [$staff->employee_id] {$staff->employee_name}", ['data' => $staff]);
                    continue;
                }

                $user = User::updateOrCreate(
                    ['employee_id' => $staff->employee_id],
                    (array) $staff
                );

                if ($user->wasRecentlyCreated) {
                    $created += 1;
                } else {
                    $updated += 1;
                }

                $unit = $user->units()->updateOrCreate(
                    [
                        'source_type' => $sourceType,
                        'sub_unit_code' => $staff->sub_unit_code,
                        'position_name' => $staff->position_name,
                    ],
                    [
                        'branch_code' => $headUnit->branch_code,
                        'unit_code' => $headUnit->unit_code,
                        'unit_code_doc' => $headUnit->unit_code_doc,
                        'unit_name' => $headUnit->unit_name,
                        'sub_unit_code_doc' => $headUnit->sub_unit_code_doc,
                        'sub_unit_name' => $headUnit->sub_unit_name,
                        'organization_code' => $headUnit->sub_unit_code,
                        'organization_name' => $headUnit->sub_unit_name,
                        'personnel_area_code' => $staff->personnel_area_code,
                        'personnel_area_name' => $staff->personnel_area_name,
                        'employee_grade_code' => $staff->employee_grade_code,
                        'employee_grade' => $staff->employee_grade,
                        'source_type' => $sourceType,
                    ]
                );

                if ($unit) {
                    $unit->syncRoles(
                        $headUnit->position_name == replace_pgs_from_position($staff->position_name) ?
                            (explode(',', $headUnit->assigned_roles) ?? ['risk admin']) : ['risk admin']
                    );
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
