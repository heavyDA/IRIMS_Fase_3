<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RKAPProgramType extends Model
{
    protected $table = 'm_rkap_program_types';

    public function scopeParentOnly($query)
    {
        return $query->whereNull('parent_id');
    }

    public function children()
    {
        return $this->hasMany(RKAPProgramType::class, 'parent_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
