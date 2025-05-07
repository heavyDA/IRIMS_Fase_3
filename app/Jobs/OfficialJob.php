<?php

namespace App\Jobs;

use App\Enums\UnitSourceType;
use App\Models\Master\Official;
use App\Models\Master\Position;
use App\Models\User;
use App\Models\UserUnit;
use App\Services\Nadia\AuthService;
use App\Services\Nadia\EmployeeService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class OfficialJob implements ShouldQueue
{
    use Queueable;

    protected AuthService $authService;
    protected EmployeeService $employeeService;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->authService = new AuthService(
            host: config('app.nadia.url'),
            appId: config('app.nadia.app_id'),
            appKey: config('app.nadia.app_secret'),
            timeout: 20
        );

        $this->employeeService = new EmployeeService(
            host: config('app.nadia.url'),
            appId: config('app.nadia.app_id'),
            appKey: config('app.nadia.app_secret'),
            token: $this->authService->login_system()->getToken(),
            timeout: 20
        );
    }

    public function handle(): void
    {
        $start = microtime(true);
        try {
            $officials = $this->employeeService->official_get_all();
            $personnelAreas = [];
            $created = 0;
            $updated = 0;

            if ($officials->isEmpty()) {
                throw new Exception('No data fetched');
            }

            DB::statement('TRUNCATE m_officials;');
            foreach ($officials as $official) {
                $official = Official::create($official->toArray());
                $created += 1;

                $user = User::firstOrCreate([
                    'username' => $official->username,
                ], $official->toArray());

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

                $personnelAreas = array_merge($personnelAreas, [$official->personnel_area_code => $official->personnel_area_name]);
            }

            if (!empty($personnelAreas)) {
                foreach ($personnelAreas as $code => $name) {
                    $code = $code == 'HO' ? 'PST' : $code;
                    Position::where('branch_code', $code)->update(['branch_name' => $name]);
                }
            }

            logger()->info("[Official Job] successfully fetched data number of created {$created} and updated {$updated} in " . (microtime(true) - $start) . " seconds");
        } catch (Exception $e) {
            logger()->error('[Official Job] ' . $e->getMessage() . " in " . (microtime(true) - $start) . " seconds");
        }
    }
}
