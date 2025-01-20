<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'm_positions';

    protected $fillable = [
        'personnel_area_code',
        'unit_code',
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
}
