<?php

namespace App\Models\Risk;

use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentType;
use App\Models\Master\RKAPProgramType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class WorksheetMitigation extends Model
{
    protected $table = 'ra_worksheet_mitigations';
    protected $fillable = [
        'worksheet_incident_id',
        'risk_treatment_option_id',
        'risk_treatment_type_id',
        'mitigation_plan',
        'mitigation_output',
        'mitigation_start_date',
        'mitigation_end_date',
        'mitigation_cost',
        'mitigation_rkap_program_type_id',
        'mitigation_pic',
        'unit_code',
        'unit_name',
        'personnel_area_code',
        'personnel_area_name',
        'position_name',
    ];

    public function FormatStartDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($this->attributes['mitigation_start_date']),
        );
    }

    public function FormatEndDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($this->attributes['mitigation_end_date']),
        );
    }

    public function incident()
    {
        return $this->belongsTo(WorksheetIncident::class, 'worksheet_incident_id');
    }

    public function risk_treatment_option()
    {
        return $this->belongsTo(RiskTreatmentOption::class, 'risk_treatment_option_id');
    }

    public function risk_treatment_type()
    {
        return $this->belongsTo(RiskTreatmentType::class, 'risk_treatment_type_id');
    }

    public function rkap_program_type()
    {
        return $this->belongsTo(RKAPProgramType::class, 'mitigation_rkap_program_type_id');
    }
}
