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
            (
                $user->personnel_area_code == 'PST' &&
                in_array($role, ['risk analis', 'risk reviewer'])
            ) ||
            $user->sub_unit_code == 'ap'
        ) {
            return 'ap%';
        }

        if (
            $role != 'risk admin'
        ) {
            return $user->sub_unit_code . '.%';
        }

        return $user->sub_unit_code;
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

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function scopeIgnoreRoot($query)
    {
        return $query->where('name', '!=', 'root');
    }
}
