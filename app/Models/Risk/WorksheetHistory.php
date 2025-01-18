<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\RBAC\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = DocumentStatus::tryFrom($this->attributes['status']);
                $label = $status->label();
                $color = $status->color();
                return view('components.badge', compact('label', 'color'));
            }
        );
    }

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
