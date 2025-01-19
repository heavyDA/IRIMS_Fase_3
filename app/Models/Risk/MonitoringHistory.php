<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class MonitoringHistory extends Model
{
    protected $table = 'ra_monitoring_histories';

    protected $fillable = [
        'monitoring_id',
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
}
