<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class WorksheetMonitoringResidual extends Model
{
    protected $table = 'ra_worksheet_monitoring_residuals';

    protected $fillable = [
        'worksheet_monitoring_id',
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
}
