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
        $role = session()->get('current_role')?->name;

        if (
            $user->personnel_area_code == 'PST' &&
            in_array($role, ['risk analis', 'risk reviewer'])
        ) {
            return 'ap%';
        }
        if (
            str_contains($user->personnel_area_code, 'REG ') &&
            in_array($role, ['risk analis', 'risk otorisator'])
        ) {
            return $user->sub_unit_code . '%';
        }

        if (
            in_array($role, ['risk otorisator', 'risk owner'])
        ) {
            return $user->sub_unit_code . '%';
        }

        return $user->sub_unit_code;
    }

    public static function getLevel()
    {
        $unit = str_replace('%', '', static::getDefaultSubUnit());
        $count = preg_match_all('/\./', $unit, $matches);

        return $count;
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
