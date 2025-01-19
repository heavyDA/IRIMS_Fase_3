<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Traits\HasEncryptedId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_monitorings';

    protected $fillable = [
        'worksheet_id',
        'period_date',
        'created_by',
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

    protected function statusTableAction(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $status = DocumentStatus::tryFrom($this->attributes['status']);
                $class = $status->color();
                $route = route('risk.monitoring.show_monitoring', $this->getEncryptedId());
                $key = $this->attributes['id'];

                return view('risk.monitoring._table_status', compact('status', 'class', 'route', 'key'));
            },
        );
    }

    protected function periodDateFormat(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>  Carbon::parse($this->attributes['period_date']),
        );
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function histories()
    {
        return $this->hasMany(MonitoringHistory::class)->latest();
    }

    public function last_history()
    {
        return $this->hasOne(MonitoringHistory::class)->latest();
    }

    public function alteration()
    {
        return $this->hasOne(MonitoringAlteration::class);
    }

    public function actualizations()
    {
        return $this->hasMany(MonitoringActualization::class);
    }

    public function incident()
    {
        return $this->hasOne(MonitoringIncident::class);
    }

    public function residuals()
    {
        return $this->hasMany(MonitoringResidual::class);
    }

    public function residual()
    {
        return $this->hasOne(MonitoringResidual::class)->latest();
    }
}
