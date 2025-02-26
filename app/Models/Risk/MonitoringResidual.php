<?php

namespace App\Models\Risk;

use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;
use Illuminate\Database\Eloquent\Model;

class MonitoringResidual extends Model
{
    protected $table = 'ra_monitoring_residuals';

    protected $fillable = [
        'monitoring_id',
        'quarter',
        'impact_scale_id',
        'impact_probability_scale_id',
        'impact_probability',
        'impact_value',
        'risk_exposure',
        'risk_level',
        'risk_scale',
        'risk_mitigation_effectiveness',
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id', 'id');
    }

    public function impact_scale()
    {
        return $this->belongsTo(BUMNScale::class, 'impact_scale_id', 'id');
    }

    public function impact_probability_scale()
    {
        return $this->belongsTo(Heatmap::class, 'impact_probability_scale_id', 'id');
    }

    public function incident()
    {
        return $this->belongsTo(WorksheetIncident::class, 'worksheet_incident_id');
    }
}
