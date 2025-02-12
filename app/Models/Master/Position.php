<?php

namespace App\Models\Master;

use App\Models\RBAC\Role;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'm_positions';

    protected $fillable = [
        'personnel_area_code',
        'unit_code',
        'unit_code_doc',
        'unit_name',
        'position_name',
        'assigned_roles',
    ];

    public function scopeUserAssignedRoles($query, string $personnel_area_code, string $position_name)
    {
        return $query
            ->where('personnel_area_code', $personnel_area_code)
            ->where('position_name', $position_name);
    }

    public function scopeUnitOnly($query)
    {
        return $query->distinct()->select('personnel_area_code', 'unit_name');
    }

    public function scopeGetSubUnitOnly($query)
    {
        return $query->distinct()->select('sub_unit_code', 'sub_unit_name', 'personnel_area_code')->oldest('sub_unit_code');
    }

    public function scopeFilterByRole($query)
    {
        $unit = Role::getDefaultSubUnit();
        $role = session()->get('current_role') ?? auth()->user()->roles()->first();
        return $query->whereLike('sub_unit_code', $unit)
        ->when(
            $role->name == 'risk owner',
            fn($q) => $q->orWhereLike('sub_unit_code', str_replace('.%', '', $unit))
        );
    }
}
