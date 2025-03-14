<?php

namespace App\Models\Master;

use App\Models\RBAC\Role;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $table = 'm_officials';

    protected $fillable = [
        'email',
        'username',
        'employee_id',
        'employee_name',
        'unit_code',
        'unit_name',
        'sub_unit_code',
        'sub_unit_name',
        'organization_code',
        'organization_name',
        'personnel_area_code',
        'personnel_area_name',
        'position_name',
        'employee_grade_code',
        'employee_grade',
    ];

    public function scopeUserAssignedRoles($query, string $personnel_area_code, string $position_name)
    {
        return $query
            ->where('personnel_area_code', $personnel_area_code)
            ->where('position_name', $position_name);
    }

    public function scopeGetSubUnitOnly($query)
    {
        return $query->select('sub_unit_code', 'sub_unit_name', 'personnel_area_code')->oldest('sub_unit_code');
    }

    public function scopeFilterByRole($query)
    {
        $unit = Role::getDefaultSubUnit();
        return $query->whereLike('sub_unit_code', $unit)
            ->orWhereLike('sub_unit_code', str_replace('.%', '', $unit));
    }
}
