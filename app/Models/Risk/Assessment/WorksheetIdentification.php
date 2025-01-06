<?php

namespace App\Models\Risk\Assessment;

use App\Models\Master\ControlEffectivenessAssessment;
use App\Models\Master\ExistingControlType;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\KBUMNTarget;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class WorksheetIdentification extends Model
{
    protected $table = 'ra_worksheet_identifications';

    protected $fillable = [
        'worksheet_target_id',
        'kbumn_target_id',
        'risk_category_id',
        'risk_category_t2_id',
        'risk_category_t3_id',
        'existing_control_type_id',
        'existing_control_body',
        'control_effectiveness_assessment_id',

        'risk_impact_category',
        'risk_impact_body',
        'risk_impact_start_date',
        'risk_impact_end_date',
    ];

    protected function FormatRiskStartDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($this->attributes['risk_impact_start_date']),
        );
    }

    protected function FormatRiskEndDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($this->attributes['risk_impact_end_date']),
        );
    }

    public function inherent()
    {
        return $this->hasOne(WorksheetIdentificationInherent::class);
    }

    public function residuals()
    {
        return $this->hasMany(WorksheetIdentificationResidual::class);
    }

    public function incidents()
    {
        return $this->hasMany(WorksheetIdentificationIncident::class);
    }

    public function kbumn_target()
    {
        return $this->belongsTo(KBUMNTarget::class);
    }

    public function risk_category_t2()
    {
        return $this->belongsTo(KBUMNRiskCategory::class, 'risk_category_t2_id');
    }

    public function risk_category_t3()
    {
        return $this->belongsTo(KBUMNRiskCategory::class, 'risk_category_t3_id');
    }

    public function existing_control_type()
    {
        return $this->belongsTo(ExistingControlType::class);
    }

    public function control_effectiveness_assessment()
    {
        return $this->belongsTo(ControlEffectivenessAssessment::class);
    }
}
