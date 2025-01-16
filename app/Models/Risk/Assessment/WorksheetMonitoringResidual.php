<?php

namespace App\Models\Risk\Assessment;

use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;
use Illuminate\Database\Eloquent\Model;

class WorksheetMonitoringResidual extends Model
{
    protected $table = 'ra_worksheet_monitoring_residuals';

    protected $fillable = [
        'worksheet_monitoring_id',
        'worksheet_identification_incident_id',
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
        return $this->belongsTo(WorksheetIdentificationIncident::class, 'worksheet_identification_incident_id');
    }
}
