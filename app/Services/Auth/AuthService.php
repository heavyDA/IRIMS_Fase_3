<?php

namespace App\Services\Auth;

use App\Enums\UnitSourceType;
use App\Exceptions\Services\AuthServiceException;
use App\Models\Master\Position;
use App\Models\User;
use App\Services\EOffice\AuthService as EOfficeAuthService;
use App\Services\Nadia\AuthService as NadiaAuthService;
use Exception;
use Illuminate\Http\Response;

class AuthService
{
    private EOfficeAuthService $eofficeAuthService;
    private NadiaAuthService $nadiaAuthService;

    public function __construct()
    {
        $this->eofficeAuthService = new EOfficeAuthService(config('app.eoffice.url'), config('app.eoffice.token'));
        $this->nadiaAuthService = new NadiaAuthService(
            config('app.nadia.url'),
            config('app.nadia.app_id'),
            config('app.nadia.app_secret'),
        );
    }

    public function login($credentials): bool
    {
        $result = $this->loginViaNadia($credentials);
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
            role()->setCurrentUnit($unit);

            $roles = $unit->roles()->get();
            if ($roles->isEmpty()) {
                $unit->syncRoles(['risk admin']);
                $roles = $unit->roles()->get();
            }

            $role = $roles->first();
            if (!$role) {
                auth()->logout();
                session()->flush();
                throw new AuthServiceException("User with {$user->username} ({$user->employee_id}) for User Unit ID {$unit->id} {$unit->position_name} doesn't have assigned roles.");
            }

            role()->setCurrentRole($role);
            role()->setCurrentRoles($roles);

            return true;
        }

        throw new AuthServiceException(__('auth.failed'), Response::HTTP_BAD_REQUEST);
    }

    protected function loginViaEOffice($credentials): bool
    {
        try {
            $employee = $this->eofficeAuthService->login($credentials);
            $employee->is_active = true;

            $user = User::firstOrCreate(['username' => $employee->username, 'employee_id' => $employee->employee_id], (array) $employee);

            $unit = null;

            if ($user->wasRecentlyCreated) {
                $unit = $user->units()->create((array) $employee + [
                    'branch_code' => $employee->personnel_area_code,
                    'source_type' => UnitSourceType::EOFFICE->value,
                ]);
            } else {
                $user->update((array) $employee);
                $unit = $user->units()
                    ->where('sub_unit_code', $employee->sub_unit_code)
                    ->where('position_name', $employee->position_name)
                    ->first();
            }

            if (auth()->loginUsingId($user->id)) {
                if (!$unit) {
                    $unit = $user->units()->create((array) $employee + [
                        'branch_code' => $employee->personnel_area_code,
                        'source_type' => UnitSourceType::EOFFICE->value,
                    ]);
                }

                /** 
                 * Check if the user unit is populated from E-Office
                 * since E-Office will have assigned roles to its position
                 * this process is necessary to give user valid roles
                 */
                if ($unit->source_type === UnitSourceType::EOFFICE->value) {
                    $position = Position::where('sub_unit_code', $unit->sub_unit_code)
                        ->first();

                    if ($position) {
                        $unit->update([
                            'unit_code_doc' => $position->unit_code_doc,
                            'sub_unit_code_doc' => $position->sub_unit_code_doc,
                        ]);
                        $unit->syncRoles(
                            $position->position_name == replace_pgs_from_position($employee->position_name) ?
                                (explode(',', $position->assigned_roles) ?? ['risk admin']) :
                                ['risk admin']
                        );
                    }
                }

                $roles = $unit->roles()->get();
                $role = $roles->first();
                if (!$role) {
                    auth()->logout();
                    session()->flush();
                    throw new AuthServiceException("User with {$user->username} ({$user->employee_id}) for User Unit ID {$unit->id} {$unit->position_name} doesn't have assigned roles.");
                }

                role()->setCurrentRoles($roles);
                role()->setCurrentRole($role);
                role()->setCurrentUnit($unit);
            }

            return true;
        } catch (Exception $e) {
            auth()->logout();
            session()->flush();
            logger()->error("[Authentication] Error when authenticating user {$credentials['username']} using E-Office: " . $e->getMessage());
        }

        return false;
    }

    protected function loginViaNadia($credentials): bool
    {
        try {
            $employee = $this->nadiaAuthService->login_system()
                ->login_user($credentials);

            $user = User::firstOrCreate(
                ['username' => $employee->username, 'employee_id' => $employee->employee_id],
                $employee->toArray() + ['is_active' => true]
            );

            $unit = null;
            if ($user->wasRecentlyCreated) {
                $unit = $user->units()->create(
                    $employee->toArray() +
                        [
                            'branch_code' => $employee->personnel_area_code,
                            'source_type' => UnitSourceType::EOFFICE->value,
                        ]
                );
            } else {
                $user->update($employee->toArray());
                $unit = $user->units()
                    ->where('sub_unit_code', $employee->sub_unit_code)
                    ->where('position_name', $employee->position_name)
                    ->first();
            }

            if (auth()->loginUsingId($user->id)) {
                if (!$unit) {
                    $unit = $user->units()->create(
                        $employee->toArray() +
                            [
                                'branch_code' => $employee->personnel_area_code,
                                'source_type' => UnitSourceType::EOFFICE->value,
                            ]
                    );
                }

                /** 
                 * Check if the user unit is populated from E-Office
                 * since E-Office will have assigned roles to its position
                 * this process is necessary to give user valid roles
                 */
                if ($unit->source_type === UnitSourceType::EOFFICE->value) {
                    $position = Position::where('sub_unit_code', $unit->sub_unit_code)
                        ->first();

                    if ($position) {
                        $unit->update([
                            'unit_code_doc' => $position->unit_code_doc,
                            'sub_unit_code_doc' => $position->sub_unit_code_doc,
                        ]);
                        $unit->syncRoles(
                            $position->position_name == replace_pgs_from_position($employee->position_name) ?
                                (explode(',', $position->assigned_roles) ?? ['risk admin']) :
                                ['risk admin']
                        );
                    }
                }

                $roles = $unit->roles()->get();
                $role = $roles->first();
                if (!$role) {
                    auth()->logout();
                    session()->flush();
                    throw new AuthServiceException("User with {$user->username} ({$user->employee_id}) for User Unit ID {$unit->id} {$unit->position_name} doesn't have assigned roles.");
                }

                role()->setCurrentUnit($unit);
                role()->setCurrentRole($role);
                role()->setCurrentRoles($roles);
            }

            return true;
        } catch (Exception $e) {
            auth()->logout();
            session()->flush();
            logger()->error("[Authentication] Error when authenticating user {$credentials['username']}: " . $e->getMessage());
        }

        return false;
    }

    public function logout()
    {
        cache()->delete('current_unit_hierarchy.' . auth()->user()->employee_id . '.' . session()->get('current_unit', auth()->user())->sub_unit_code);
        cache()->delete('current_units.' . auth()->user()->employee_id);

        session()->flush();
        auth()->logout();
    }
}
