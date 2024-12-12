<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    public function scopeGetSelectedByRole($query, $role)
    {
        return $query
            ->select('menus.id', 'menus.name', 'menus.route', 'menus.icon_name', 'menus.icon_alias', DB::raw('IF(menu_role.menu_id, true, false) as selected'))
            ->leftJoin('menu_role', fn ($join) => $join->on('menu_role.menu_id', '=', 'menus.id')->on('menu_role.role_id', '=', DB::raw($role)))
            ->get();
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
