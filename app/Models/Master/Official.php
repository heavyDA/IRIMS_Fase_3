<?php

namespace App\Models\Master;

use App\Models\RBAC\Role;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    protected $table = 'm_officials';

    public function scopeGetSubUnitOnly($query)
    {
        return $query->distinct()->select('sub_unit_code', 'sub_unit_name', 'personnel_area_code')->oldest('sub_unit_code');
    }

    public function scopeFilterByRole($query)
    {
        return $query->where('sub_unit_code', 'like', Role::getDefaultSubUnit());
    }
}
