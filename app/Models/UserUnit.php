<?php

namespace App\Models;

use App\Enums\UnitSourceType;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable as AccessAuthorizable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class UserUnit extends Model implements Authorizable
{
    use HasRoles, AccessAuthorizable;

    protected $fillable = [
        'user_id',
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
        'source_type',
        'expired_at',
    ];

    protected $guard_name = 'web';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByScopeAndExpiredAt($query)
    {
        return $query->where(
            fn($q) => $q->where('source_type', UnitSourceType::EOFFICE)
                ->orWhere(
                    fn($q) => $q->where('source_type', UnitSourceType::SYSTEM)
                        ->where('expired_at', '>=', now())
                )
        );
    }
}
