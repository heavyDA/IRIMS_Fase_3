<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use App\Models\UserUnit;
use Illuminate\Session\SessionManager;

class RoleService
{
    public function __construct(protected SessionManager $session) {}

    public function isRiskAdmin()
    {
        return $this->getCurrentRole()->name == 'risk admin';
    }

    public function isRiskOwner()
    {
        return $this->getCurrentRole()->name == 'risk owner';
    }

    public function isRiskAnalis()
    {
        return str_contains($this->getCurrentRole()->name, 'risk analis');
    }

    public function isRiskOtorisator()
    {
        return $this->getCurrentRole()->name == 'risk otorisator';
    }

    public function isRiskOtorisatorWorksheetApproval()
    {
        if (!$this->isRiskOtorisator()) return false;

        $unit = $this->getCurrentUnit();
        $unitLevel = $this->getUnitLevel();

        return
            !(
                $unitLevel < 3 && $unit?->personnel_area_code == 'CGK' ||
                $unitLevel == 1 && $unit?->personnel_area_code == 'DPS'
            );
    }

    public function isRiskOtorisatorTopRiskApproval()
    {
        if (!$this->isRiskOtorisator()) return false;

        $unit = $this->getCurrentUnit();
        $unitLevel = $this->getUnitLevel();
        return
            !(
                $unitLevel > 2 && $unit?->personnel_area_code == 'CGK' ||
                $unitLevel == 1 && $unit?->personnel_area_code == 'DPS'
            );
    }

    public function isRiskReviewer()
    {
        return $this->getCurrentRole()->name == 'risk reviewer';
    }

    public function isAdministrator()
    {
        return in_array($this->getCurrentRole()->name, ['root', 'administrator']);
    }

    public function setCurrentRoles($roles): void
    {
        $this->session->put('current_roles', $roles);
    }

    public function getCurrentRoles()
    {
        return $this->session->get('current_roles');
    }

    public function setCurrentRole(Role $role): void
    {
        $this->session->put('current_role', $role);
    }

    public function getCurrentRole()
    {
        return $this->session->get('current_role');
    }

    /**
     * Check Permissions of current role
     * by implementing role direct permission from spatie/Laravel-permission
     * https://spatie.be/docs/laravel-permission/v6/basic-usage/role-permissions#content-assigning-permissions-to-roles
     * instead of authenticated user or model since we are enabled
     * user to change their roles so we just needs to check the role permissions
     * directly by get the current role from session
     * 
     * @param string $name
     * @return bool
     */
    public function checkPermission(?string $name = ''): bool
    {
        return empty($name) ? false : $this->getCurrentRole()->hasPermissionTo($name);
    }

    public function setCurrentUnit(UserUnit $unit): void
    {
        $this->session->put('current_unit', $unit);
    }

    public function getCurrentUnit()
    {
        return $this->session->get('current_unit');
    }

    public function getUnitLevel()
    {
        $unit = $this->getCurrentUnit()?->sub_unit_code;
        if ($unit) {
            return get_unit_level($unit);
        }

        return -1;
    }

    public function getTraverseUnitLevel(?string $unit = '', int $maxTraverse = 6): array
    {
        $level = $unit ? get_unit_level($unit) : $this->getUnitLevel();

        if ($this->getCurrentRole()->name == 'risk admin') {
            return [$level, $level];
        } else if ($this->getCurrentRole()->name == 'risk owner') {
            $maxTraverse = 1;
        }

        $traverse = $level;
        for ($t = 0; $t < $maxTraverse; $t++) {
            $traverse++;
        }
        return [$level, $traverse];
    }
}
