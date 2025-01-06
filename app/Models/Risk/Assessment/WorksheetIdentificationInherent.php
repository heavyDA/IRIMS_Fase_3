<?php

namespace App\Models\Risk\Assessment;

use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;
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

    public function impact_probability_scale()
    {
        return $this->belongsTo(Heatmap::class, 'impact_probability_scale_id', 'id');
    }

    public function impact_scale()
    {
        return $this->belongsTo(BUMNScale::class, 'impact_scale_id', 'id');
    }
}
