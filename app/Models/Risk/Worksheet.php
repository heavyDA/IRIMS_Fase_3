<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\RBAC\Role;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worksheet extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheets';

    protected $fillable = [
        'worksheet_code',
        'worksheet_number',
        'unit_code',
        'unit_name',
        'sub_unit_code',
        'sub_unit_name',
        'organization_code',
        'organization_name',
        'personnel_area_code',
        'personnel_area_name',
        'company_code',
        'company_name',
        'target_body',
        'status',
        'status_monitoring',
    ];

    public function scopeActiveYear($query, $year = null)
    {
        return $query->whereYear('created_at', $year ?? date('Y'));
    }

    public function scopeSubUnit($query, string $role, string $unit)
    {
        if (Role::hasLookUpUnitHierarchy($role)) {
            return $query->where('sub_unit_code', 'like', '%' . $unit);
        }

        return $query->where('sub_unit_code', $unit);
    }

    public function scopeDocumentStatus($query, ?string $status)
    {
        if (!$status) {
            return $query;
        }

        if (in_array($status, ['draft', 'approved'])) {
            return $query->whereStatus($status);
        }

        return $query->whereNotIn('status', ['draft', 'approved']);
    }

    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = DocumentStatus::tryFrom($this->attributes['status']);
                $label = $status->label();
                $color = $status->color();
                return view('components.badge', compact('label', 'color'));
            }
        );
    }

    protected function periodDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->format('M d, Y'),
        );
    }

    protected function periodYear(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->format('Y'),
        );
    }

    public function strategies()
    {
        return $this->hasMany(WorksheetStrategy::class);
    }

    public function identification()
    {
        return $this->hasOne(WorksheetIdentification::class);
    }


    public function incidents()
    {
        return $this->hasMany(WorksheetIncident::class);
    }


    public function last_history()
    {
        return $this->hasOne(WorksheetHistory::class)->latest();
    }

    public function histories()
    {
        return $this->hasMany(WorksheetHistory::class)->latest();
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }

    public function latest_monitoring()
    {
        return $this->hasOne(Monitoring::class)->latest('period_date');
    }

    public function last_top_risk()
    {
        return $this->hasOne(WorksheetTopRisk::class)->latest('id');
    }

    public function monitoring_residuals()
    {
        return $this->hasManyThrough(
            MonitoringResidual::class,
            Monitoring::class,
            'worksheet_id',
            'worksheet_monitoring_id',
            'id',
            'id'
        );
    }

    public static function top_risk_lower_query($unit)
    {
        return DB::table('ra_worksheets as w')
            ->select(
                'w.id',
                'winc.worksheet_id',
                'winc.risk_cause_number',
                'winc.risk_cause_code',
                'winc.risk_cause_body',
                'winc.kri_body',
                'winc.kri_unit_id',
                'winc.kri_threshold_safe',
                'winc.kri_threshold_caution',
                'winc.kri_threshold_danger',

                'w.worksheet_code',
                'w.worksheet_number',
                'w.unit_code',
                'w.unit_name',
                'w.sub_unit_code',
                'w.sub_unit_name',
                'w.organization_code',
                'w.organization_name',
                'w.personnel_area_code',
                'w.personnel_area_name',
                'w.company_code',
                'w.company_name',
                'w.target_body',
                'w.status',
                'w.status_monitoring',

                'wi.existing_control_body',

                'wi.risk_chronology_body',
                'wi.risk_chronology_description',
                'wi.risk_impact_category',
                'wi.risk_impact_body',
                'wi.risk_impact_start_date',
                'wi.risk_impact_end_date',

                'wi.inherent_body',
                'wi.inherent_impact_value',
                'wi.inherent_impact_probability',
                'wi.inherent_risk_exposure',
                'wi.inherent_risk_level',
                'wi.inherent_risk_scale',

                'wi.residual_1_impact_value',
                'wi.residual_1_impact_probability',
                'wi.residual_1_risk_exposure',
                'wi.residual_1_risk_level',
                'wi.residual_1_risk_scale',
                'wi.residual_2_impact_value',
                'wi.residual_2_impact_probability',
                'wi.residual_2_risk_exposure',
                'wi.residual_2_risk_level',
                'wi.residual_2_risk_scale',
                'wi.residual_3_impact_value',
                'wi.residual_3_impact_probability',
                'wi.residual_3_risk_exposure',
                'wi.residual_3_risk_level',
                'wi.residual_3_risk_scale',
                'wi.residual_4_impact_value',
                'wi.residual_4_impact_probability',
                'wi.residual_4_risk_exposure',
                'wi.residual_4_risk_level',
                'wi.residual_4_risk_scale',

                'kri_unit.name as kri_unit_name',
                'm_existing_control_types.name as existing_control_type_name',
                'm_control_effectiveness_assessments.name as control_effectiveness_assessment_name',
                'rc_t2.name as risk_category_t2_name',
                'rc_t3.name as risk_category_t3_name',
                'i.scale as inherent_impact_scale',
                'r1.scale as residual_1_impact_scale',
                'r2.scale as residual_2_impact_scale',
                'r3.scale as residual_3_impact_scale',
                'r4.scale as residual_4_impact_scale',
                'h_i.risk_scale as inherent_impact_probability_scale',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r4.risk_scale as residual_4_impact_probability_scale',

                'wtr.id as top_risk_id',
                'wtr.sub_unit_code as destination_sub_unit_code',
                'wtr.source_sub_unit_code',
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin(
                'ra_worksheet_top_risks as wtr',
                fn($q) => $q->on('wtr.worksheet_id', '=', 'w.id')
                    ->where('wtr.source_sub_unit_code', 'like', $unit)
            )
            ->leftJoin('m_kri_units as kri_unit', 'kri_unit.id', '=', 'winc.kri_unit_id')
            ->leftJoin('m_existing_control_types', 'm_existing_control_types.id', '=', 'wi.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments', 'm_control_effectiveness_assessments.id', '=', 'wi.control_effectiveness_assessment_id')
            ->leftJoin('risk_categories as rc_t2', 'rc_t2.id', '=', 'wi.risk_category_t2_id')
            ->leftJoin('risk_categories as rc_t3', 'rc_t3.id', '=', 'wi.risk_category_t3_id')
            ->leftJoin('scales as i', 'i.id', '=', 'wi.inherent_impact_scale_id')
            ->leftJoin('scales as r1', 'r1.id', '=', 'wi.residual_1_impact_scale_id')
            ->leftJoin('scales as r2', 'r2.id', '=', 'wi.residual_2_impact_scale_id')
            ->leftJoin('scales as r3', 'r3.id', '=', 'wi.residual_3_impact_scale_id')
            ->leftJoin('scales as r4', 'r4.id', '=', 'wi.residual_4_impact_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'wi.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'wi.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'wi.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'wi.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'wi.residual_4_impact_probability_scale_id');
    }

    public static function top_risk_upper_query($unit)
    {
        return DB::table('ra_worksheets as w')
            ->select(
                'w.id',
                'winc.worksheet_id',
                'winc.risk_cause_number',
                'winc.risk_cause_code',
                'winc.risk_cause_body',
                'winc.kri_body',
                'winc.kri_unit_id',
                'winc.kri_threshold_safe',
                'winc.kri_threshold_caution',
                'winc.kri_threshold_danger',

                'w.worksheet_code',
                'w.worksheet_number',
                'w.unit_code',
                'w.unit_name',
                'w.sub_unit_code',
                'w.sub_unit_name',
                'w.organization_code',
                'w.organization_name',
                'w.personnel_area_code',
                'w.personnel_area_name',
                'w.company_code',
                'w.company_name',
                'w.target_body',
                'w.status',
                'w.status_monitoring',

                'wi.existing_control_body',

                'wi.risk_chronology_body',
                'wi.risk_chronology_description',
                'wi.risk_impact_category',
                'wi.risk_impact_body',
                'wi.risk_impact_start_date',
                'wi.risk_impact_end_date',

                'wi.inherent_body',
                'wi.inherent_impact_value',
                'wi.inherent_impact_probability',
                'wi.inherent_risk_exposure',
                'wi.inherent_risk_level',
                'wi.inherent_risk_scale',

                'wi.residual_1_impact_value',
                'wi.residual_1_impact_probability',
                'wi.residual_1_risk_exposure',
                'wi.residual_1_risk_level',
                'wi.residual_1_risk_scale',
                'wi.residual_2_impact_value',
                'wi.residual_2_impact_probability',
                'wi.residual_2_risk_exposure',
                'wi.residual_2_risk_level',
                'wi.residual_2_risk_scale',
                'wi.residual_3_impact_value',
                'wi.residual_3_impact_probability',
                'wi.residual_3_risk_exposure',
                'wi.residual_3_risk_level',
                'wi.residual_3_risk_scale',
                'wi.residual_4_impact_value',
                'wi.residual_4_impact_probability',
                'wi.residual_4_risk_exposure',
                'wi.residual_4_risk_level',
                'wi.residual_4_risk_scale',

                'kri_unit.name as kri_unit_name',
                'm_existing_control_types.name as existing_control_type_name',
                'm_control_effectiveness_assessments.name as control_effectiveness_assessment_name',
                'rc_t2.name as risk_category_t2_name',
                'rc_t3.name as risk_category_t3_name',
                'i.scale as inherent_impact_scale',
                'r1.scale as residual_1_impact_scale',
                'r2.scale as residual_2_impact_scale',
                'r3.scale as residual_3_impact_scale',
                'r4.scale as residual_4_impact_scale',
                'h_i.risk_scale as inherent_impact_probability_scale',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r4.risk_scale as residual_4_impact_probability_scale',

                'wtr.id as top_risk_id',
                'wtr.sub_unit_code as destination_sub_unit_code',
                'wtr.source_sub_unit_code',

                'wtr_submit.id as top_risk_submit_id',
                'wtr_submit.sub_unit_code as submit_destination_sub_unit_code',
                'wtr_submit.source_sub_unit_code as submit_source_sub_unit_code',
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin(
                'ra_worksheet_top_risks as wtr',
                fn($q) => $q->on('wtr.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr.source_sub_unit_code', $unit)
            )
            ->leftJoin(
                'ra_worksheet_top_risks as wtr_submit',
                fn($q) => $q->on('wtr_submit.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr_submit.source_sub_unit_code', str_replace('%', '', $unit))
            )
            ->leftJoin('m_kri_units as kri_unit', 'kri_unit.id', '=', 'winc.kri_unit_id')
            ->leftJoin('m_existing_control_types', 'm_existing_control_types.id', '=', 'wi.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments', 'm_control_effectiveness_assessments.id', '=', 'wi.control_effectiveness_assessment_id')
            ->leftJoin('risk_categories as rc_t2', 'rc_t2.id', '=', 'wi.risk_category_t2_id')
            ->leftJoin('risk_categories as rc_t3', 'rc_t3.id', '=', 'wi.risk_category_t3_id')
            ->leftJoin('scales as i', 'i.id', '=', 'wi.inherent_impact_scale_id')
            ->leftJoin('scales as r1', 'r1.id', '=', 'wi.residual_1_impact_scale_id')
            ->leftJoin('scales as r2', 'r2.id', '=', 'wi.residual_2_impact_scale_id')
            ->leftJoin('scales as r3', 'r3.id', '=', 'wi.residual_3_impact_scale_id')
            ->leftJoin('scales as r4', 'r4.id', '=', 'wi.residual_4_impact_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'wi.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'wi.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'wi.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'wi.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'wi.residual_4_impact_probability_scale_id');
    }

    public static function top_risk_upper_dashboard_query($unit)
    {
        return DB::table('ra_worksheets as w')
            ->select(
                'w.id',
                'winc.worksheet_id',
                'winc.risk_cause_number',
                'winc.risk_cause_code',
                'winc.risk_cause_body',
                'winc.kri_body',
                'winc.kri_unit_id',
                'winc.kri_threshold_safe',
                'winc.kri_threshold_caution',
                'winc.kri_threshold_danger',

                'wim.mitigation_plan',
                'wim.mitigation_output',
                'wim.mitigation_pic',

                'mr.risk_scale',
                'mr.risk_level',

                'w.worksheet_code',
                'w.worksheet_number',
                'w.unit_code',
                'w.unit_name',
                'w.sub_unit_code',
                'w.sub_unit_name',
                'w.organization_code',
                'w.organization_name',
                'w.personnel_area_code',
                'w.personnel_area_name',
                'w.company_code',
                'w.company_name',
                'w.target_body',
                'w.status',
                'w.status_monitoring',

                'wi.existing_control_body',

                'wi.risk_chronology_body',
                'wi.risk_chronology_description',
                'wi.risk_impact_category',
                'wi.risk_impact_body',
                'wi.risk_impact_start_date',
                'wi.risk_impact_end_date',

                'wi.inherent_body',
                'wi.inherent_impact_value',
                'wi.inherent_impact_probability',
                'wi.inherent_risk_exposure',
                'wi.inherent_risk_level',
                'wi.inherent_risk_scale',

                'wi.residual_1_impact_value',
                'wi.residual_1_impact_probability',
                'wi.residual_1_risk_exposure',
                'wi.residual_1_risk_level',
                'wi.residual_1_risk_scale',
                'wi.residual_2_impact_value',
                'wi.residual_2_impact_probability',
                'wi.residual_2_risk_exposure',
                'wi.residual_2_risk_level',
                'wi.residual_2_risk_scale',
                'wi.residual_3_impact_value',
                'wi.residual_3_impact_probability',
                'wi.residual_3_risk_exposure',
                'wi.residual_3_risk_level',
                'wi.residual_3_risk_scale',
                'wi.residual_4_impact_value',
                'wi.residual_4_impact_probability',
                'wi.residual_4_risk_exposure',
                'wi.residual_4_risk_level',
                'wi.residual_4_risk_scale',

                'kri_unit.name as kri_unit_name',
                'm_existing_control_types.name as existing_control_type_name',
                'm_control_effectiveness_assessments.name as control_effectiveness_assessment_name',
                'rc_t2.name as risk_category_t2_name',
                'rc_t3.name as risk_category_t3_name',
                'i.scale as inherent_impact_scale',
                'r1.scale as residual_1_impact_scale',
                'r2.scale as residual_2_impact_scale',
                'r3.scale as residual_3_impact_scale',
                'r4.scale as residual_4_impact_scale',
                'h_i.risk_scale as inherent_impact_probability_scale',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r4.risk_scale as residual_4_impact_probability_scale',

                'wtr.id as top_risk_id',
                'wtr.sub_unit_code as destination_sub_unit_code',
                'wtr.source_sub_unit_code',

                'wtr_submit.id as top_risk_submit_id',
                'wtr_submit.sub_unit_code as submit_destination_sub_unit_code',
                'wtr_submit.source_sub_unit_code as submit_source_sub_unit_code',
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_mitigations as wim', 'wim.worksheet_incident_id', '=', 'winc.id')
            ->leftJoin('ra_monitorings as m', 'lm.worksheet_id', '=', 'w.id')
            ->joinSub(
                DB::table('ra_monitorings')
                    ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                    ->groupBy('worksheet_id'),
                'lm',
                function ($join) {
                    $join->on('m.worksheet_id', '=', 'w.id');
                    $join->on('m.period_date', '=', 'lm.period_date');
                }
            )
            ->leftJoin('ra_monitoring_residuals as mr', 'mr.monitoring', '=', 'lm.id')
            ->leftJoin(
                'ra_worksheet_top_risks as wtr',
                fn($q) => $q->on('wtr.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr.source_sub_unit_code', $unit)
            )
            ->leftJoin(
                'ra_worksheet_top_risks as wtr_submit',
                fn($q) => $q->on('wtr_submit.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr_submit.source_sub_unit_code', str_replace('%', '', $unit))
            )
            ->leftJoin('m_kri_units as kri_unit', 'kri_unit.id', '=', 'winc.kri_unit_id')
            ->leftJoin('m_existing_control_types', 'm_existing_control_types.id', '=', 'wi.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments', 'm_control_effectiveness_assessments.id', '=', 'wi.control_effectiveness_assessment_id')
            ->leftJoin('risk_categories as rc_t2', 'rc_t2.id', '=', 'wi.risk_category_t2_id')
            ->leftJoin('risk_categories as rc_t3', 'rc_t3.id', '=', 'wi.risk_category_t3_id')
            ->leftJoin('scales as i', 'i.id', '=', 'wi.inherent_impact_scale_id')
            ->leftJoin('scales as r1', 'r1.id', '=', 'wi.residual_1_impact_scale_id')
            ->leftJoin('scales as r2', 'r2.id', '=', 'wi.residual_2_impact_scale_id')
            ->leftJoin('scales as r3', 'r3.id', '=', 'wi.residual_3_impact_scale_id')
            ->leftJoin('scales as r4', 'r4.id', '=', 'wi.residual_4_impact_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'wi.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'wi.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'wi.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'wi.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'wi.residual_4_impact_probability_scale_id');
    }

    public static function latest_monitoring_with_mitigation_query()
    {
        return DB::table('worksheets as w')
            ->withExpression(
                'worksheets',
                Worksheet::from('ra_worksheets as w')->select(
                    'w.id',
                    'w.worksheet_number',
                    'w.target_body',
                    'wi.risk_chronology_body',
                    'wi.inherent_risk_level',
                    'wi.inherent_risk_scale',

                    'w.personnel_area_code',
                    'w.personnel_area_name',
                    'w.unit_code',
                    'w.unit_name',
                    'w.sub_unit_code',
                    'w.sub_unit_name',

                    'status',
                    'status_monitoring',
                    DB::raw('YEAR(w.created_at) as worksheet_year')
                )
                    ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
                    ->whereStatus(DocumentStatus::APPROVED->value)
            )
            ->withExpression(
                'latest_monitoring',
                DB::table('ra_monitorings as m')
                    ->select('m.*')
                    ->joinSub(
                        DB::table('ra_monitorings')
                            ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                            ->groupBy('worksheet_id'),
                        'latest',
                        function ($join) {
                            $join->on('m.worksheet_id', '=', 'latest.worksheet_id');
                            $join->on('m.period_date', '=', 'latest.period_date');
                        }
                    )
            )
            ->select(
                'lm.id as latest_monitoring_id',
                'w.id as worksheet_id',
                'w.worksheet_number',
                'w.target_body',
                'w.risk_chronology_body',

                'ma.quarter',
                'wmit.mitigation_plan',
                'ma.actualization_plan_output',

                'w.inherent_risk_level',
                'w.inherent_risk_scale',
                'mr.risk_level as residual_risk_level',
                'mr.risk_scale as residual_risk_scale',
                'w.personnel_area_code',
                'w.personnel_area_name',
                'w.unit_code',
                'w.unit_name',
                'w.sub_unit_code',
                'w.sub_unit_name',

                'w.status',
                'w.status_monitoring'
            )
            ->leftJoin('latest_monitoring as lm', 'lm.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_monitoring_actualizations as ma', 'ma.monitoring_id', '=', 'lm.id')
            ->leftJoin('ra_worksheet_mitigations as wmit', 'wmit.id', '=', 'ma.worksheet_mitigation_id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.id', '=', 'wmit.worksheet_incident_id')
            ->leftJoin(
                'ra_monitoring_residuals as mr',
                function ($join) {
                    $join->on('mr.monitoring_id', '=', 'lm.id')
                        ->whereRaw('mr.worksheet_incident_id = winc.id');
                }
            );
    }
}
