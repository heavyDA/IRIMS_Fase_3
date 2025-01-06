<?php

namespace App\Models\Risk\Assessment;

use App\Models\RBAC\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WorksheetHistory extends Model
{
    protected $table = 'ra_worksheet_histories';

    protected $fillable = [
        'worksheet_id',
        'created_by',
        'created_role',
        'receiver_id',
        'receiver_role',
        'note',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'created_role');
    }

    public function receiver()
    {
        return $this->belongsTo(Role::class, 'receiver_role');
    }
}
