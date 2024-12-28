<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class WorksheetIdentificationInherent extends Model
{
    protected $table = 'ra_worksheet_identification_inherents';
    protected $fillable = [
        'body',
        'impact_probability',
        'impact_probability_scale_id',
        'impact_scale_id',
        'impact_value',
        'risk_exposure',
        'risk_level',
        'risk_scale',
    ];
}
