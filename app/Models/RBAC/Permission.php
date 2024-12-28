<?php

namespace App\Models\RBAC;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    public function scopeGetSelectedByRole($query, $role)
    {
        return $query
            ->select('permissions.id', 'permissions.name', DB::raw('IF(role_has_permissions.permission_id, true, false) as selected'))
            ->leftJoin('role_has_permissions', fn ($join) => $join->on('role_has_permissions.permission_id', '=', 'permissions.id')->on('role_has_permissions.role_id', '=', DB::raw($role)))
            ->get();
    }
}
