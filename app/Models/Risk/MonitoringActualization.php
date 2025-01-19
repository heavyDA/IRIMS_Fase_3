<?php

namespace App\Models\Risk;

use App\Models\Master\KRIUnit;
use Illuminate\Database\Eloquent\Model;

class MonitoringActualization extends Model
{
    protected $table = 'ra_monitoring_actualizations';

    protected $fillable = [
        'monitoring_id',
        'worksheet_mitigation_id',
        'actualization_mitigation_plan',
        'actualization_cost',
        'actualization_cost_absorption',
        'quarter',
        'documents',
        'kri_unit_id',
        'kri_threshold',
        'kri_threshold_score',
        'actualization_plan_body',
        'actualization_plan_output',
        'actualization_plan_status',
        'actualization_plan_explanation',
        'actualization_plan_progress',
        'unit_code',
        'unit_name',
        'personnel_area_code',
        'position_name',
    ];

    protected $casts = [
        'documents' => 'json',
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id');
    }

    public function mitigation()
    {
        return $this->belongsTo(WorksheetMitigation::class, 'worksheet_mitigation_id');
    }

    public function kri_unit()
    {
        return $this->belongsTo(KRIUnit::class, 'kri_unit_id');
    }
}
