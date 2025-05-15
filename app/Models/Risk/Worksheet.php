<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\Master\Position;
use App\Models\RBAC\Role;
use App\Models\User;
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
        'risk_qualification_id',
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
        'created_by',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
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

    public function alterations()
    {
        return $this->hasMany(WorksheetAlteration::class);
    }

    public static function risk_map_inherent_query(string $unit, int $year)
    {
        return DB::table('m_heatmaps as h')
            ->withExpression(
                'worksheets',
                DB::table('ra_worksheets as w')
                    ->selectRaw('personnel_area_code, sub_unit_code, wi.inherent_impact_probability_scale_id')
                    ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
                    ->where(
                        fn($q) => $q->whereLike('sub_unit_code', $unit)
                            ->when(
                                session()->get('current_role')?->name == 'risk owner',
                                fn($q) => $q->orWhereLike('sub_unit_code', str_replace('.%', '',  $unit))
                            )
                    )
                    ->when(str_contains(session()->get('current_unit')->personnel_area_code, 'REG '), fn($q) => $q->whereNotLike('personnel_area_code', 'REG %'))
                    ->whereYear('w.created_at', $year)
            )
            ->selectRaw('
                h.risk_level,
                h.color,
                COALESCE(COUNT(w.sub_unit_code), 0) as count
            ')
            ->leftJoin('worksheets as w', 'w.inherent_impact_probability_scale_id', '=', 'h.id')
            ->orderBy('risk_scale', 'asc')
            ->groupBy('h.risk_level');
    }

    public static function topRiskLowerQuery(?string $unit)
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
                'rq.name as risk_qualification_name',
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
                'h_i.impact_probability as inherent_impact_probability_probability_scale',
                'h_i.risk_level as inherent_impact_probability_level',
                'h_i.color as inherent_impact_probability_color',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r1.risk_level as residual_1_impact_probability_level',
                'h_r1.color as residual_1_impact_probability_color',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r2.risk_level as residual_2_impact_probability_level',
                'h_r2.color as residual_2_impact_probability_color',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r3.risk_level as residual_3_impact_probability_level',
                'h_r3.color as residual_3_impact_probability_color',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
                'h_r4.risk_level as residual_4_impact_probability_level',
                'h_r4.color as residual_4_impact_probability_color',

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
                    ->where('wtr.source_sub_unit_code', $unit)
            )
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
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

    public static function topRiskLowerDashboardQuery($unit)
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

                'mr.id as mr_id',
                'h_mr.risk_scale as actual_risk_scale',
                'h_mr.risk_level as actual_risk_level',
                'h_mr.color as actual_risk_color',

                'w.worksheet_code',
                'w.worksheet_number',
                'rq.name as risk_qualification_name',
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
                'h_i.impact_probability as inherent_impact_probability_probability_scale',
                'h_i.risk_level as inherent_impact_probability_level',
                'h_i.color as inherent_impact_probability_color',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r1.risk_level as residual_1_impact_probability_level',
                'h_r1.color as residual_1_impact_probability_color',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r2.risk_level as residual_2_impact_probability_level',
                'h_r2.color as residual_2_impact_probability_color',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r3.risk_level as residual_3_impact_probability_level',
                'h_r3.color as residual_3_impact_probability_color',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
                'h_r4.risk_level as residual_4_impact_probability_level',
                'h_r4.color as residual_4_impact_probability_color',

                'wtr.id as top_risk_id',
                'wtr.sub_unit_code as destination_sub_unit_code',
                'wtr.source_sub_unit_code'
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_mitigations as wim', 'wim.worksheet_incident_id', '=', 'winc.id')
            ->leftJoin('ra_monitorings as m', 'm.worksheet_id', '=', 'w.id')
            ->leftJoinSub(
                DB::table('ra_monitorings')
                    ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                    ->groupBy('worksheet_id'),
                'lm',
                function ($join) {
                    $join->on('m.worksheet_id', '=', 'w.id');
                    $join->on('m.period_date', '=', 'lm.period_date');
                }
            )
            ->leftJoin('ra_monitoring_residuals as mr', 'mr.monitoring_id', '=', 'm.id')
            ->leftJoin('ra_worksheet_top_risks as wtr', 'wtr.worksheet_id', '=', 'w.id')
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
            ->leftJoin('heatmaps as h_mr', 'h_mr.id', '=', 'mr.impact_probability_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'wi.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'wi.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'wi.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'wi.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'wi.residual_4_impact_probability_scale_id');
    }

    public static function topRiskUpperQuery(?string $unit, ?string $subUnit)
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
                'rq.name as risk_qualification_name',
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
                'h_i.impact_probability as inherent_impact_probability_probability_scale',
                'h_i.risk_level as inherent_impact_probability_level',
                'h_i.color as inherent_impact_probability_color',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r1.risk_level as residual_1_impact_probability_level',
                'h_r1.color as residual_1_impact_probability_color',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r2.risk_level as residual_2_impact_probability_level',
                'h_r2.color as residual_2_impact_probability_color',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r3.risk_level as residual_3_impact_probability_level',
                'h_r3.color as residual_3_impact_probability_color',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
                'h_r4.risk_level as residual_4_impact_probability_level',
                'h_r4.color as residual_4_impact_probability_color',

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
            ->leftJoin('ra_worksheet_top_risks as wtr', 'wtr.worksheet_id', '=', 'w.id')
            ->leftJoin(
                'ra_worksheet_top_risks as wtr_submit',
                fn($q) => $q->on('wtr_submit.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr_submit.source_sub_unit_code', $subUnit)
            )
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
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
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'wi.residual_4_impact_probability_scale_id')
            ->groupBy('winc.id');
    }

    public static function topRiskUpperDashboardQuery(?string $unit, ?string $subUnit)
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

                'mr.id as mr_id',
                'h_mr.risk_scale as actual_risk_scale',
                'h_mr.risk_level as actual_risk_level',
                'h_mr.color as actual_risk_color',

                'w.worksheet_code',
                'w.worksheet_number',
                'rq.name as risk_qualification_name',
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
                'h_i.impact_probability as inherent_impact_probability_probability_scale',
                'h_i.risk_level as inherent_impact_probability_level',
                'h_i.color as inherent_impact_probability_color',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r1.risk_level as residual_1_impact_probability_level',
                'h_r1.color as residual_1_impact_probability_color',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r2.risk_level as residual_2_impact_probability_level',
                'h_r2.color as residual_2_impact_probability_color',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r3.risk_level as residual_3_impact_probability_level',
                'h_r3.color as residual_3_impact_probability_color',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
                'h_r4.risk_level as residual_4_impact_probability_level',
                'h_r4.color as residual_4_impact_probability_color',

                'wtr.id as top_risk_id',
                'wtr.sub_unit_code as destination_sub_unit_code',
                'wtr.source_sub_unit_code',

                'wtr_submit.id as top_risk_submit_id',
                'wtr_submit.sub_unit_code as submit_destination_sub_unit_code',
                'wtr_submit.source_sub_unit_code as submit_source_sub_unit_code'
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_mitigations as wim', 'wim.worksheet_incident_id', '=', 'winc.id')
            ->leftJoin('ra_monitorings as m', 'm.worksheet_id', '=', 'w.id')
            ->leftJoinSub(
                DB::table('ra_monitorings')
                    ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                    ->groupBy('worksheet_id'),
                'lm',
                function ($join) {
                    $join->on('m.worksheet_id', '=', 'w.id');
                    $join->on('m.period_date', '=', 'lm.period_date');
                }
            )
            ->leftJoin('ra_monitoring_residuals as mr', 'mr.monitoring_id', '=', 'm.id')
            ->join(
                'ra_worksheet_top_risks as wtr',
                fn($q) => $q->on('wtr.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr.sub_unit_code', $unit)
            )
            ->leftJoin(
                'ra_worksheet_top_risks as wtr_submit',
                fn($q) => $q->on('wtr_submit.worksheet_id', '=', 'w.id')
                    ->whereLike('wtr_submit.source_sub_unit_code', $subUnit)
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
            ->leftJoin('heatmaps as h_mr', 'h_mr.id', '=', 'mr.impact_probability_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'wi.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'wi.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'wi.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'wi.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'wi.residual_4_impact_probability_scale_id');
    }

    public static function latestMonitoringWithMitigationQuery()
    {
        return DB::table('worksheets as w')
            ->withExpression(
                'worksheets',
                Worksheet::from('ra_worksheets as w')->select(
                    'w.id',
                    'w.worksheet_number',
                    'w.target_body',
                    'w.risk_qualification_id',
                    'rq.name as risk_qualification_name',
                    'rc_t2.name as risk_category_t2_name',
                    'rc_t3.name as risk_category_t3_name',
                    'wi.risk_chronology_body',
                    'wi.inherent_impact_probability_scale_id',
                    'wi.inherent_risk_exposure',

                    'w.personnel_area_code',
                    'w.personnel_area_name',
                    'w.unit_code',
                    'w.unit_name',
                    'w.sub_unit_code',
                    'w.sub_unit_name',

                    'status',
                    'status_monitoring',
                    'w.created_by',
                    'w.created_at',
                    DB::raw('YEAR(w.created_at) as worksheet_year')
                )
                    ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
                    ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
                    ->leftJoin('m_kbumn_risk_categories as rc_t2', 'rc_t2.id', '=', 'wi.risk_category_t2_id')
                    ->leftJoin('m_kbumn_risk_categories as rc_t3', 'rc_t3.id', '=', 'wi.risk_category_t3_id')
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
                'w.risk_qualification_name',
                'ma.quarter',
                'wmit.mitigation_plan',
                'ma.actualization_plan_output',

                'w.risk_category_t2_name',
                'w.risk_category_t3_name',
                'hi.color as inherent_risk_color',
                'hi.risk_level as inherent_risk_level',
                'hi.risk_scale as inherent_risk_scale',
                'hi.impact_probability as inherent_risk_impact_probability_scale',
                'w.inherent_risk_exposure',
                'hr.color as residual_risk_color',
                'hr.risk_level as residual_risk_level',
                'hr.risk_scale as residual_risk_scale',
                'hr.impact_probability as residual_risk_impact_probability_scale',
                'mr.risk_exposure as residual_risk_exposure',
                'w.personnel_area_code',
                'w.personnel_area_name',
                'w.unit_code',
                'w.unit_name',
                'w.sub_unit_code',
                'w.sub_unit_name',

                'w.status',
                'w.status_monitoring',
                'w.created_by',
                'lm.created_at',
                'lm.period_date'
            )
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->leftJoin('heatmaps as hi', 'hi.id', '=', 'w.inherent_impact_probability_scale_id')
            ->leftJoin('latest_monitoring as lm', 'lm.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_monitoring_actualizations as ma', 'ma.monitoring_id', '=', 'lm.id')
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_mitigations as wmit', 'wmit.worksheet_incident_id', '=', 'winc.id')
            ->leftJoin('ra_monitoring_residuals as mr', 'mr.monitoring_id', '=', 'lm.id')
            ->leftJoin('heatmaps as hr', 'hr.id', '=', 'mr.impact_probability_scale_id')
            ->groupBy('lm.id', 'wmit.id');
    }

    public static function progressMonitoringQuery(?string $unitCode = 'ap', ?int $year = null)
    {
        return Position::hierarchyWithTraverseQuery(unitCode: $unitCode)
            ->withExpression(
                'worksheets',
                DB::table('children as c')
                    ->selectRaw("
                    c.sub_unit_code,
                    COALESCE(COUNT(distinct w.id),0) as total_worksheet    
                ")
                    ->leftJoin('position_hierarchy as ph', 'ph.unit_code', 'c.sub_unit_code')
                    ->leftJoin(
                        'ra_worksheets as w',
                        fn($q) => $q->on('w.sub_unit_code', '=', 'ph.sub_unit_code')
                            ->whereYear('w.created_at', $year ?? Date('Y'))
                    )
                    ->groupBy('c.sub_unit_code')
            )
            ->withExpression(
                'monitorings',
                DB::table('children as c')
                    ->selectRaw("
                        c.sub_unit_code,
                        month(period_date) as period_month,
                        COALESCE(COUNT(IF(m.status = 'approved', m.id, NULL)),0) as total_approved   
                    ")
                    ->leftJoin('position_hierarchy as ph', 'ph.unit_code', 'c.sub_unit_code')
                    ->leftJoin(
                        'ra_worksheets as w',
                        fn($q) => $q->on('w.sub_unit_code', '=', 'ph.sub_unit_code')
                            ->whereYear('w.created_at', $year ?? Date('Y'))
                    )
                    ->leftJoin('ra_monitorings as m', 'm.worksheet_id', 'w.id')
                    ->groupBy('c.sub_unit_code', 'period_month')
            )
            ->selectRaw("
                children.*,
                w.total_worksheet,
                COALESCE(SUM(CASE WHEN m.period_month = 1 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 1 THEN w.total_worksheet END), 0) * 100 AS m1,
                
                COALESCE(SUM(CASE WHEN m.period_month = 2 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 2 THEN w.total_worksheet END), 0) * 100 AS m2,
                
                COALESCE(SUM(CASE WHEN m.period_month = 3 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 3 THEN w.total_worksheet END), 0) * 100 AS m3,
                
                COALESCE(SUM(CASE WHEN m.period_month = 4 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 4 THEN w.total_worksheet END), 0) * 100 AS m4,
                
                COALESCE(SUM(CASE WHEN m.period_month = 5 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 5 THEN w.total_worksheet END), 0) * 100 AS m5,
                
                COALESCE(SUM(CASE WHEN m.period_month = 6 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 6 THEN w.total_worksheet END), 0) * 100 AS m6,
                
                COALESCE(SUM(CASE WHEN m.period_month = 7 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 7 THEN w.total_worksheet END), 0) * 100 AS m7,
                
                COALESCE(SUM(CASE WHEN m.period_month = 8 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 8 THEN w.total_worksheet END), 0) * 100 AS m8,
                
                COALESCE(SUM(CASE WHEN m.period_month = 9 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 9 THEN w.total_worksheet END), 0) * 100 AS m9,
                
                COALESCE(SUM(CASE WHEN m.period_month = 10 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 10 THEN w.total_worksheet END), 0) * 100 AS m10,
                
                COALESCE(SUM(CASE WHEN m.period_month = 11 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 11 THEN w.total_worksheet END), 0) * 100 AS m11,
                
                COALESCE(SUM(CASE WHEN m.period_month = 12 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 12 THEN w.total_worksheet END), 0) * 100 AS m12
        ")
            ->leftJoin('worksheets as w', 'w.sub_unit_code', '=', 'children.sub_unit_code')
            ->leftJoin('monitorings as m', 'm.sub_unit_code', '=', 'children.sub_unit_code')
            ->groupBy('children.sub_unit_code');
    }

    public static function progressMonitoringRiskOwnerQuery(?string $unitCode, ?int $year = null)
    {
        return Position::hierarchyQuery($unitCode, true)
            ->withExpression(
                'worksheets',
                DB::table('position_hierarchy as ph')
                    ->selectRaw("
                    '{$unitCode}' as current_unit_code,
                    ph.sub_unit_code,
                    COALESCE(COUNT(distinct w.id),0) as total_worksheet    
                ")
                    ->leftJoin(
                        'ra_worksheets as w',
                        fn($q) => $q->on('w.sub_unit_code', '=', 'ph.sub_unit_code')
                            ->whereYear('w.created_at', $year ?? Date('Y'))
                    )
                    ->groupBy('current_unit_code')
            )
            ->withExpression(
                'monitorings',
                DB::table('position_hierarchy as ph')
                    ->selectRaw("
                        '{$unitCode}' as current_unit_code,
                        ph.sub_unit_code,
                        month(period_date) as period_month,
                        COALESCE(COUNT(IF(m.status = 'approved', m.id, NULL)),0) as total_approved   
                    ")
                    ->leftJoin(
                        'ra_worksheets as w',
                        fn($q) => $q->on('w.sub_unit_code', '=', 'ph.sub_unit_code')
                            ->whereYear('w.created_at', $year ?? Date('Y'))
                    )
                    ->leftJoin('ra_monitorings as m', 'm.worksheet_id', 'w.id')
                    ->groupBy('current_unit_code', 'period_month')
            )
            ->selectRaw("
                position_hierarchy.*,
                w.total_worksheet,
                COALESCE(SUM(CASE WHEN m.period_month = 1 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 1 THEN w.total_worksheet END), 0) * 100 AS m1,
                
                COALESCE(SUM(CASE WHEN m.period_month = 2 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 2 THEN w.total_worksheet END), 0) * 100 AS m2,
                
                COALESCE(SUM(CASE WHEN m.period_month = 3 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 3 THEN w.total_worksheet END), 0) * 100 AS m3,
                
                COALESCE(SUM(CASE WHEN m.period_month = 4 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 4 THEN w.total_worksheet END), 0) * 100 AS m4,
                
                COALESCE(SUM(CASE WHEN m.period_month = 5 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 5 THEN w.total_worksheet END), 0) * 100 AS m5,
                
                COALESCE(SUM(CASE WHEN m.period_month = 6 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 6 THEN w.total_worksheet END), 0) * 100 AS m6,
                
                COALESCE(SUM(CASE WHEN m.period_month = 7 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 7 THEN w.total_worksheet END), 0) * 100 AS m7,
                
                COALESCE(SUM(CASE WHEN m.period_month = 8 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 8 THEN w.total_worksheet END), 0) * 100 AS m8,
                
                COALESCE(SUM(CASE WHEN m.period_month = 9 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 9 THEN w.total_worksheet END), 0) * 100 AS m9,
                
                COALESCE(SUM(CASE WHEN m.period_month = 10 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 10 THEN w.total_worksheet END), 0) * 100 AS m10,
                
                COALESCE(SUM(CASE WHEN m.period_month = 11 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 11 THEN w.total_worksheet END), 0) * 100 AS m11,
                
                COALESCE(SUM(CASE WHEN m.period_month = 12 THEN m.total_approved END), 0)
                / NULLIF(SUM(CASE WHEN m.period_month = 12 THEN w.total_worksheet END), 0) * 100 AS m12
        ")
            ->leftJoin('worksheets as w', 'w.current_unit_code', '=', 'position_hierarchy.sub_unit_code')
            ->leftJoin('monitorings as m', 'm.current_unit_code', '=', 'position_hierarchy.sub_unit_code')
            ->groupBy('position_hierarchy.sub_unit_code');
    }

    public static function assessmentQuery()
    {
        return DB::table('ra_worksheets as w')
            ->select(
                'w.worksheet_code',
                'w.worksheet_number',
                'rq.name as risk_qualification_name',
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

                'winc.id',
                'winc.worksheet_id',
                'winc.risk_cause_number',
                'winc.risk_cause_code',
                'winc.risk_cause_body',
                'winc.kri_body',
                'winc.kri_unit_id',
                'winc.kri_threshold_safe',
                'winc.kri_threshold_caution',
                'winc.kri_threshold_danger',
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

                'ku.name as kri_unit_name',
                'ect.name as existing_control_type_name',
                'cea.name as control_effectiveness_assessment_name',
                'rc_t2.name as risk_category_t2_name',
                'rc_t3.name as risk_category_t3_name',
                'i.scale as inherent_impact_scale',
                'r1.scale as residual_1_impact_scale',
                'r2.scale as residual_2_impact_scale',
                'r3.scale as residual_3_impact_scale',
                'r4.scale as residual_4_impact_scale',
                'h_i.risk_scale as inherent_impact_probability_scale',
                'h_i.impact_probability as inherent_impact_probability_probability_scale',
                'h_i.risk_level as inherent_impact_probability_level',
                'h_i.color as inherent_impact_probability_color',
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r1.risk_level as residual_1_impact_probability_level',
                'h_r1.color as residual_1_impact_probability_color',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r2.risk_level as residual_2_impact_probability_level',
                'h_r2.color as residual_2_impact_probability_color',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r3.risk_level as residual_3_impact_probability_level',
                'h_r3.color as residual_3_impact_probability_color',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
                'h_r4.risk_level as residual_4_impact_probability_level',
                'h_r4.color as residual_4_impact_probability_color',
                'w.created_at'
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('ra_worksheet_incidents as winc', 'winc.worksheet_id', '=', 'w.id')
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
            ->leftJoin('m_kri_units as ku', 'ku.id', '=', 'winc.kri_unit_id')
            ->leftJoin('m_existing_control_types as ect', 'ect.id', '=', 'wi.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments as cea', 'cea.id', '=', 'wi.control_effectiveness_assessment_id')
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

    public static function residualMapQuery(?int $quarter = 1)
    {
        return DB::table('ra_worksheets as w')
            ->select(
                'wi.worksheet_id',
                'w.worksheet_code',
                'w.worksheet_number',
                'rq.name as risk_qualification_name',
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
                'wi.inherent_risk_exposure',

                "wi.residual_{$quarter}_risk_exposure as residual_risk_exposure",
                "h_r{$quarter}.risk_scale as residual_risk_scale",
                "h_r{$quarter}.impact_probability as residual_impact_probability_scale",
                "h_r{$quarter}.risk_level as residual_risk_level",
                "h_r{$quarter}.color as residual_risk_color",

                'ect.name as existing_control_type_name',
                'cea.name as control_effectiveness_assessment_name',
                'rc_t2.name as risk_category_t2_name',
                'rc_t3.name as risk_category_t3_name',
                'i.scale as inherent_impact_scale',
                'r1.scale as residual_1_impact_scale',
                'r2.scale as residual_2_impact_scale',
                'r3.scale as residual_3_impact_scale',
                'r4.scale as residual_4_impact_scale',

                'h_i.risk_scale as inherent_impact_probability_scale',
                'h_i.impact_probability as inherent_impact_probability_probability_scale',
                'h_i.risk_level as inherent_impact_probability_level',
                'h_i.color as inherent_impact_probability_color',
                'w.created_at'
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('ra_worksheet_identifications as wi', 'wi.worksheet_id', '=', 'w.id')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id')
            ->leftJoin('m_existing_control_types as ect', 'ect.id', '=', 'wi.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments as cea', 'cea.id', '=', 'wi.control_effectiveness_assessment_id')
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

    public function scopeGetCountByStatus($query)
    {
        $table = app(self::class)->getTable();

        return $query
            ->selectRaw("
                COALESCE(COUNT(IF({$table}.status = 'draft', 1, NULL))) as draft,
                COALESCE(COUNT(IF({$table}.status != 'draft' and {$table}.status != 'approved', 1, NULL))) as progress,
                COALESCE(COUNT(IF({$table}.status = 'approved', 1, NULL))) as approved
            ");
    }
}
