<?php

namespace App\Models\Risk\Assessment;

use App\Models\Master\KRIUnit;
use Illuminate\Database\Eloquent\Model;

class WorksheetIdentificationIncident extends Model
{
    protected $table = 'ra_worksheet_identification_incidents';
    protected $fillable = [
        'worksheet_identification_id',
        'risk_chronology_body',
        'risk_chronology_description',

        'risk_cause_number',
        'risk_cause_code',
        'risk_cause_body',

        'kri_body',
        'kri_unit_id',
        'kri_threshold_safe',
        'kri_threshold_caution',
        'kri_threshold_danger',
    ];

    public function inherent()
    {
        return $this->hasOne(WorksheetIdentificationInherent::class);
    }

    public function residuals()
    {
        return $this->hasMany(WorksheetIdentificationResidual::class);
    }

    public function mitigations()
    {
        return $this->hasMany(WorksheetIdentificationIncidentMitigation::class);
    }

    public function kri_unit()
    {
        return $this->belongsTo(KRIUnit::class);
    }
}
