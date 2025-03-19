<?php

namespace App\Services\Auth;

use App\Enums\UnitSourceType;
use App\Exceptions\Services\AuthServiceException;
use App\Models\Master\Position;
use App\Models\User;
use App\Services\EOffice\AuthService as EOfficeAuthService;
use Exception;
use Illuminate\Http\Response;

class AuthService
{
    private EOfficeAuthService $eofficeAuthService;

    public function __construct()
    {
        $this->eofficeAuthService = new EOfficeAuthService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
    }

    public function login($credentials): bool
    {
        $result = $this->loginViaEOffice($credentials);
        if (!$result) {
            $result = $this->loginViaLocal($credentials);
        }

        return $result;
    }

    protected function loginViaLocal($credentials): bool
    {
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $unit = $user->units()->first();
            if (!$unit) {
                auth()->logout();
                session()->flush();
                throw new AuthServiceException("User with {$user->username} ({$user->employee_id}) doesn't have assigned units");
            }
            session()->put('current_unit', $unit);

            $role = $unit->roles()->first();
            if (!$role) {
                auth()->logout();
                session()->flush();
                throw new AuthServiceException("User with {$user->username} ({$user->employee_id}) for User Unit ID {$unit->id} {$unit->position_name} doesn't have assigned roles.");
            }
            session()->put('current_role', $role);

            return true;
        }

        throw new AuthServiceException(__('auth.failed'), Response::HTTP_BAD_REQUEST);
    }

    protected function loginViaEOffice($credentials): bool
    {
        try {
            $employee = $this->eofficeAuthService->login($credentials);
            $employee->is_active = true;

            $user = User::firstOrCreate(['employee_id' => $employee->employee_id], (array) $employee);

            $unit = null;
            if ($user->wasRecentlyCreated) {
                $unit = $user->units()->create((array) $employee + [
                    'source_type' => UnitSourceType::EOFFICE->value,
                ]);
            } else {
                $user->update((array) $employee);
            }

            if (auth()->loginUsingId($user->id)) {
                $user->update((array) $employee);

                if (!$unit) {
                    $unit = $user->units()
                        ->where('sub_unit_code', $employee->sub_unit_code)
                        ->where('position_name', $employee->position_name)
                        ->firstOrFail();
                }

                /** 
                 * Check if the user unit is populated from E-Office
                 * since E-Office will have assigned roles to its position
                 * this process is necessary to give user valid roles
                 */
                if ($unit->source_type === UnitSourceType::EOFFICE->value) {
                    $position = Position::where('sub_unit_code', $unit->sub_unit_code)
                        ->where('position_name', replace_pgs_from_position($unit->position_name))
                        ->first();

                    if ($position) {
                        $unit->syncRoles(explode(',', $position->assigned_roles) ?? ['risk admin']);
                    }
                }

                session()->put('current_unit', $unit);
                session()->put('current_role', $unit->roles()->first());
            }

            return true;
        } catch (Exception $e) {
            auth()->logout();
            session()->flush();
            logger()->error('[Authentication] Error when authenticating using E-Office: ' . $e->getMessage(), [$e]);
        }

        return false;
    }

    public function logout()
    {
        cache()->delete('current_unit_hierarchy.' . auth()->user()->employee_id . '.' . session()->get('current_unit', auth()->user())->sub_unit_code);
        cache()->delete('current_units.' . auth()->user()->employee_id);
        cache()->delete('current_roles.' . auth()->user()->employee_id);

        session()->flush();
        auth()->logout();
    }
}
