<?php

namespace App\Models\Risk\Assessment;

use App\Enums\DocumentStatus;
use App\Traits\HasEncryptedId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class WorksheetMonitoring extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_monitorings';

    protected $fillable = [
        'worksheet_id',
        'period_date',
        'created_by',
        'status',
    ];

    public function statusTableAction(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $status = DocumentStatus::tryFrom($this->attributes['status']);
                $class = $status->color();
                $route = route('risk.process.monitoring.show_monitoring', $this->getEncryptedId());
                $key = $this->attributes['id'];

                return view('risk.process.monitoring._table_status', compact('status', 'class', 'route', 'key'));
            },
        );
    }

    public function periodDateFormat(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>  Carbon::parse($this->attributes['period_date']),
        );
    }

    public function histories()
    {
        return $this->hasMany(WorksheetMonitoringHistory::class);
    }

    public function last_history()
    {
        return $this->hasOne(WorksheetMonitoringHistory::class)->latest();
    }

    public function alteration()
    {
        return $this->hasOne(WorksheetMonitoringAlteration::class);
    }

    public function actualizations()
    {
        return $this->hasMany(WorksheetMonitoringActualization::class);
    }

    public function incident()
    {
        return $this->hasOne(WorksheetMonitoringIncident::class);
    }

    public function residual()
    {
        return $this->hasOne(WorksheetMonitoringResidual::class);
    }
}
