<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\Master\RiskTreatmentOption;
use App\Models\Master\RiskTreatmentType;
use App\Models\Master\RKAPProgramType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'organization_code',
        'organization_name',
        'unit_code',
        'unit_name',
        'sub_unit_code',
        'sub_unit_name',
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

    public static function mitigation_full_join_query(
        $year
    ) {
        return DB::table('ra_worksheet_mitigations as wm')
            ->withExpression(
                'worksheets',
                Worksheet::whereStatus(DocumentStatus::APPROVED->value)
                    ->whereYear('created_at', $year ?? date('Y'))
            )
            ->withExpression(
                'latest_monitorings',
                Monitoring::latest_monitoring_query()
                    ->whereRaw('m.worksheet_id IN (' . DB::table('worksheets')->select('id')->toRawSql() . ')')
            )
            ->select(
                'wi.worksheet_id',
                'w.worksheet_number',
                'rq.name as risk_qualification_name',
                'w.target_body',
                'w.sub_unit_code as worksheet_sub_unit_code',
                'w.personnel_area_code as worksheet_personnel_area_code',
                'w.status_monitoring',

                'wm.risk_treatment_option_id',
                'm_o.name as risk_treatment_option_name',
                'wm.risk_treatment_type_id',
                'm_t.name as risk_treatment_type_name',
                'wm.mitigation_plan',
                'wm.mitigation_output',
                'wm.mitigation_start_date',
                'wm.mitigation_end_date',
                'wm.mitigation_cost',
                'wm.mitigation_rkap_program_type_id',
                'wm.mitigation_pic',

                'wi.risk_cause_number',
                'wi.risk_cause_code',
                'wi.risk_cause_body',

                'wi.kri_body',
                'wi.kri_unit_id',
                'm_kri.name as kri_unit_name',
                'wi.kri_threshold_safe',
                'wi.kri_threshold_caution',
                'wi.kri_threshold_danger',

                'ma.actualization_mitigation_plan',
                'ma.actualization_cost',
                'ma.actualization_cost_absorption',
                'ma.quarter',
                'ma.documents',
                'ma.kri_threshold',
                'ma.kri_threshold_score',
                'ma.actualization_plan_body',
                'ma.actualization_plan_output',
                'ma.actualization_plan_status',
                'ma.actualization_plan_explanation',
                'ma.actualization_plan_progress',
                'ma.personnel_area_code as related_personnel_area_code',
                'ma.position_name as related_position_name',

                'mr.impact_scale_id',
                'mr.impact_probability_scale_id',
                'mr.impact_probability',
                'mr.impact_value',
                'mr.risk_exposure',
                'mr.risk_level',
                'mr.risk_scale',
                'mr.risk_mitigation_effectiveness',
            )
            ->leftJoin('ra_worksheet_incidents as wi', 'wm.worksheet_incident_id', '=', 'wi.id')
            ->leftJoin('worksheets as w', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
            ->leftJoin('m_risk_treatment_options as m_o', 'wm.risk_treatment_option_id', '=', 'm_o.id')
            ->leftJoin('m_risk_treatment_types as m_t', 'wm.risk_treatment_type_id', '=', 'm_t.id')
            ->leftJoin('m_kri_units as m_kri', 'wi.kri_unit_id', '=', 'm_kri.id')
            ->leftJoin('latest_monitorings as lm', 'lm.id', '=', 'w.id')
            ->leftJoin('ra_monitoring_actualizations as ma', 'ma.monitoring_id', '=', 'lm.id')
            ->leftJoin('ra_monitoring_residuals as mr', function ($q) {
                $q->on('mr.monitoring_id', '=', 'ma.monitoring_id');
                $q->on('mr.quarter', '=', 'ma.quarter');
            });
    }

    public function incident()
    {
        return $this->belongsTo(WorksheetIncident::class, 'worksheet_incident_id');
    }

    public function worksheet()
    {
        return $this->hasOneThrough(Worksheet::class, WorksheetIncident::class, 'id', 'id', 'worksheet_incident_id', 'worksheet_id');
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

    public function monitoring_residual()
    {
        return $this->hasOne(MonitoringResidual::class, 'worksheet_incident_id', 'worksheet_incident_id');
    }

    public function monitoring_actualization()
    {
        return $this->hasOne(MonitoringActualization::class, 'worksheet_mitigation_id');
    }
}
