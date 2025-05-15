<?php

namespace App\Models;

use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetAlteration;
use App\Models\Risk\WorksheetLossEvent;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasEncryptedId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'employee_id',
        'employee_name',
        'image_url',
        'is_active',
        'email_verified_at',

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function validateCredentials(array $credentials)
    {
        return true;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function units()
    {
        return $this->hasMany(UserUnit::class)->filterByScopeAndExpiredAt();
    }

    public function worksheet()
    {
        return $this->hasMany(Worksheet::class, 'created_by', 'employee_id');
    }

    public function worksheet_alterations()
    {
        return $this->hasMany(WorksheetAlteration::class, 'created_by', 'employee_id');
    }

    public function worksheet_loss_events()
    {
        return $this->hasMany(WorksheetLossEvent::class, 'created_by', 'employee_id');
    }
}
