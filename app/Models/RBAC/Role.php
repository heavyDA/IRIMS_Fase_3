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
            $role == 'risk otorisator'
        ) {
            return $user->unit_code . '%';
        }

        if (
            $role == 'risk otorisator'
        ) {
            return $user->unit_code . '%';
        }

        if ($role == 'risk owner') {
            return $user->sub_unit_code . '%';
        }

        return $user->sub_unit_code;
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
