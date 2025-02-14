<?php

namespace App\Models\RBAC;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    public static function hasLookUpUnitHierarchy()
    {
        $role = session()->get('current_role')?->name;
        if ($role) {
            if (in_array($role, ['risk admin', 'risk owner'])) {
                return false;
            }

            return true;
        }

        return false;
    }

    public static function getDefaultSubUnit(): string
    {
        $user = auth()->user();
        $unit = session()->get('current_unit') ?? $user;
        $role = session()->get('current_role')?->name;

        if (
            ($unit->personnel_area_code == '' && $user->hasRole('risk analis'))  ||
            $user->hasRole('risk reviewer')

        ) {
            return 'ap.%';
        }

        if (
            $role != 'risk admin'
        ) {
            return $unit->sub_unit_code . '.%';
        }
        return $unit->sub_unit_code . ($role == 'risk admin' ? '' : '.%');
    }

    public static function getLevel(?string $unit = null)
    {
        $unit = $unit ?? static::getDefaultSubUnit();
        $level = preg_match_all('/\./', str_replace('%', '', $unit), $matches);
        return $level ? $level - 1 : $level;
    }

    public static function getTraverseLevel(?string $unit = null)
    {
        $user = auth()->user();
        $unit = $unit ?? static::getDefaultSubUnit();

        $level = static::getLevel($unit);

        if ($user->personnel_area_code == 'CGK') {
            if ($level >= 3 && $level <= 4) {
                return 5;
            }
        }

        return $level + 1;
    }

    public static function risk_otorisator_worksheet_approval()
    {
        $user = session()->get('current_unit') ?? auth()->user();
        $role = session()?->get('current_role') ?? auth()->roles()->first();
        $level = Role::getLevel($user->sub_unit_code);

        if ($role->name != 'risk otorisator') {
            return false;
        }

        if (
            $user->personnel_area_code == 'CGK' &&
            $level < 3
        ) {
            return false;
        } else if (
            $user->personnel_area_code == 'DPS' &&
            $level == 1
        ) {
            return false;
        }

        return true;
    }

    public static function risk_otorisator_top_risk_approval()
    {
        $user = session()->get('current_unit') ?? auth()->user();
        $role = session()?->get('current_role') ?? auth()->roles()->first();
        $level = Role::getLevel($user->sub_unit_code);

        if ($role->name != 'risk otorisator') {
            return false;
        }

        if (
            $user->personnel_area_code == 'CGK' &&
            $level > 1
        ) {
            return false;
        } else if (
            $user->personnel_area_code == 'DPS' &&
            $level == 1
        ) {
            return false;
        }

        return true;
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function scopeIgnoreRoot($query)
    {
        return $query->where('name', '!=', 'root');
    }
}
