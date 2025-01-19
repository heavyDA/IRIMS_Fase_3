<?php

namespace App\Models\Risk;

use App\Models\Master\IncidentCategory;
use App\Models\Master\IncidentFrequency;
use App\Models\Master\KBUMNRiskCategory;
use Illuminate\Database\Eloquent\Model;

class MonitoringIncident extends Model
{
    protected $table = 'ra_monitoring_incidents';

    protected $fillable = [
        'monitoring_id',
        'incident_body',
        'incident_identification',
        'incident_category_id',
        'incident_source',
        'incident_cause',
        'incident_handling',
        'incident_description',
        'risk_category_t2_id',
        'risk_category_t3_id',
        'loss_description',
        'loss_value',
        'incident_repetitive',
        'incident_frequency_id',
        'mitigation_plan',
        'actualization_plan',
        'follow_up_plan',
        'related_party',
        'insurance_status',
        'insurance_permit',
        'insurance_claim',
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id');
    }

    public function incident_category()
    {
        return $this->belongsTo(IncidentCategory::class, 'incident_category_id');
    }

    public function incident_frequency()
    {
        return $this->belongsTo(IncidentFrequency::class, 'incident_frequency_id');
    }

    public function risk_category_t2()
    {
        return $this->belongsTo(KBUMNRiskCategory::class, 'risk_category_t2_id');
    }

    public function risk_category_t3()
    {
        return $this->belongsTo(KBUMNRiskCategory::class, 'risk_category_t3_id');
    }
}
