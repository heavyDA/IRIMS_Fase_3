<?php

namespace App\Services;

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

    public function getCurrentRole()
    {
        return $this->session->get('current_role');
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

    public function getTraverseUnitLevel(?string $unit = '', ?int $traverse = 1): array
    {
        $level = $unit ? get_unit_level($unit) : $this->getUnitLevel();

        if ($this->getCurrentRole()->name == 'risk admin') {
            return [$level, $level];
        }

        return [$level, $level >= 0 ? $level + $traverse : -1];
    }
}
