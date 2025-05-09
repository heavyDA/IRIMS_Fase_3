<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\Master\KRIUnit;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorksheetIncident extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_incidents';
    protected $fillable = [
        'worksheet_id',

        'risk_cause_number',
        'risk_cause_code',
        'risk_cause_body',

        'kri_body',
        'kri_unit_id',
        'kri_threshold_safe',
        'kri_threshold_caution',
        'kri_threshold_danger',
    ];

    public static function incident_query()
    {
        return DB::table('ra_worksheet_incidents as incident')
            ->select(
                'incident.id',
                'incident.worksheet_id',
                'incident.risk_cause_number',
                'incident.risk_cause_code',
                'incident.risk_cause_body',
                'incident.kri_body',
                'incident.kri_unit_id',
                'incident.kri_threshold_safe',
                'incident.kri_threshold_caution',
                'incident.kri_threshold_danger',

                'worksheet.worksheet_code',
                'worksheet.worksheet_number',
                'rq.name as risk_qualification_name',
                'worksheet.unit_code',
                'worksheet.unit_name',
                'worksheet.sub_unit_code',
                'worksheet.sub_unit_name',
                'worksheet.organization_code',
                'worksheet.organization_name',
                'worksheet.personnel_area_code',
                'worksheet.personnel_area_name',
                'worksheet.company_code',
                'worksheet.company_name',
                'worksheet.target_body',
                'worksheet.status',
                'worksheet.status_monitoring',

                'existing_control_body',

                'identification.risk_chronology_body',
                'identification.risk_chronology_description',
                'identification.risk_impact_category',
                'identification.risk_impact_body',
                'identification.risk_impact_start_date',
                'identification.risk_impact_end_date',

                'identification.inherent_body',
                'identification.inherent_impact_value',
                'identification.inherent_impact_probability',
                'identification.inherent_risk_exposure',
                'identification.inherent_risk_level',
                'identification.inherent_risk_scale',

                'identification.residual_1_impact_value',
                'identification.residual_1_impact_probability',
                'identification.residual_1_risk_exposure',
                'identification.residual_1_risk_level',
                'identification.residual_1_risk_scale',
                'identification.residual_2_impact_value',
                'identification.residual_2_impact_probability',
                'identification.residual_2_risk_exposure',
                'identification.residual_2_risk_level',
                'identification.residual_2_risk_scale',
                'identification.residual_3_impact_value',
                'identification.residual_3_impact_probability',
                'identification.residual_3_risk_exposure',
                'identification.residual_3_risk_level',
                'identification.residual_3_risk_scale',
                'identification.residual_4_impact_value',
                'identification.residual_4_impact_probability',
                'identification.residual_4_risk_exposure',
                'identification.residual_4_risk_level',
                'identification.residual_4_risk_scale',

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
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->leftJoin('ra_worksheets as worksheet', 'worksheet.id', '=', 'incident.worksheet_id')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'worksheet.risk_qualification_id')
            ->leftJoin('ra_worksheet_identifications as identification', 'identification.worksheet_id', '=', 'worksheet.id')
            ->leftJoin('m_kri_units as kri_unit', 'kri_unit.id', '=', 'incident.kri_unit_id')
            ->leftJoin('m_existing_control_types', 'm_existing_control_types.id', '=', 'identification.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments', 'm_control_effectiveness_assessments.id', '=', 'identification.control_effectiveness_assessment_id')
            ->leftJoin('risk_categories as rc_t2', 'rc_t2.id', '=', 'identification.risk_category_t2_id')
            ->leftJoin('risk_categories as rc_t3', 'rc_t3.id', '=', 'identification.risk_category_t3_id')
            ->leftJoin('scales as i', 'i.id', '=', 'identification.inherent_impact_scale_id')
            ->leftJoin('scales as r1', 'r1.id', '=', 'identification.residual_1_impact_scale_id')
            ->leftJoin('scales as r2', 'r2.id', '=', 'identification.residual_2_impact_scale_id')
            ->leftJoin('scales as r3', 'r3.id', '=', 'identification.residual_3_impact_scale_id')
            ->leftJoin('scales as r4', 'r4.id', '=', 'identification.residual_4_impact_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'identification.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'identification.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'identification.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'identification.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'identification.residual_4_impact_probability_scale_id');
    }
    public static function incident_query_top_risk(?string $unit = null)
    {
        return DB::table('ra_worksheet_incidents as incident')
            ->select([
                'incident.worksheet_id',
                'incident.risk_cause_number',
                'incident.risk_cause_code',
                'incident.risk_cause_body',
                'incident.kri_body',
                'incident.kri_unit_id',
                'incident.kri_threshold_safe',
                'incident.kri_threshold_caution',
                'incident.kri_threshold_danger',
                'worksheet.worksheet_number',
                'rq.name as risk_qualification_name',
                'worksheet.unit_code',
                'worksheet.unit_name',
                'worksheet.sub_unit_code',
                'worksheet.sub_unit_name',
                'worksheet.organization_code',
                'worksheet.organization_name',
                'worksheet.personnel_area_code',
                'worksheet.personnel_area_name',
                'worksheet.target_body',
                'worksheet.status',
                'existing_control_body',

                'tr.id as top_risk_id',
                'tr.sub_unit_code as top_risk_sub_unit_code',
                'tr.source_sub_unit_code as top_risk_source_sub_unit_code',

                'identification.risk_chronology_body',
                'identification.risk_chronology_description',

                'identification.risk_impact_category',
                'identification.risk_impact_body',
                'identification.risk_impact_start_date',
                'identification.risk_impact_end_date',

                'identification.inherent_body',
                'identification.inherent_impact_value',
                'identification.inherent_impact_probability',
                'identification.inherent_risk_exposure',
                'identification.inherent_risk_level',
                'identification.inherent_risk_scale',

                'identification.residual_1_impact_value',
                'identification.residual_1_impact_probability',
                'identification.residual_1_risk_exposure',
                'identification.residual_1_risk_level',
                'identification.residual_1_risk_scale',
                'identification.residual_2_impact_value',
                'identification.residual_2_impact_probability',
                'identification.residual_2_risk_exposure',
                'identification.residual_2_risk_level',
                'identification.residual_2_risk_scale',
                'identification.residual_3_impact_value',
                'identification.residual_3_impact_probability',
                'identification.residual_3_risk_exposure',
                'identification.residual_3_risk_level',
                'identification.residual_3_risk_scale',
                'identification.residual_4_impact_value',
                'identification.residual_4_impact_probability',
                'identification.residual_4_risk_exposure',
                'identification.residual_4_risk_level',
                'identification.residual_4_risk_scale',

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
                'h_r1.risk_scale as residual_1_impact_probability_scale',
                'h_r1.impact_probability as residual_1_impact_probability_probability_scale',
                'h_r2.risk_scale as residual_2_impact_probability_scale',
                'h_r2.impact_probability as residual_2_impact_probability_probability_scale',
                'h_r3.risk_scale as residual_3_impact_probability_scale',
                'h_r3.impact_probability as residual_3_impact_probability_probability_scale',
                'h_r4.risk_scale as residual_4_impact_probability_scale',
                'h_r4.impact_probability as residual_4_impact_probability_probability_scale',
            ])
            ->withExpression(
                'worksheets',
                DB::table('ra_worksheets')
                    ->whereLike('sub_unit_code', $unit)
                    ->where('status', DocumentStatus::APPROVED->value)
            )
            ->withExpression(
                'top_risks',
                DB::table('ra_worksheet_top_risks')
                    ->whereRaw('worksheet_id IN (select id from worksheets)')
                    ->where(function ($query) use ($unit) {
                        return $query->whereLike('source_sub_unit_code', $unit)
                            ->orWhereLike('sub_unit_code', $unit);
                    })
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
            ->rightJoin('worksheets as worksheet', 'worksheet.id', '=', 'incident.worksheet_id')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'worksheet.risk_qualification_id')
            ->leftJoin('top_risks as tr', 'tr.worksheet_id', '=', 'incident.worksheet_id')
            ->leftJoin('ra_worksheet_identifications as identification', 'identification.worksheet_id', '=', 'worksheet.id')
            ->leftJoin('m_kri_units as kri_unit', 'kri_unit.id', '=', 'incident.kri_unit_id')
            ->leftJoin('m_existing_control_types', 'm_existing_control_types.id', '=', 'identification.existing_control_type_id')
            ->leftJoin('m_control_effectiveness_assessments', 'm_control_effectiveness_assessments.id', '=', 'identification.control_effectiveness_assessment_id')
            ->leftJoin('risk_categories as rc_t2', 'rc_t2.id', '=', 'identification.risk_category_t2_id')
            ->leftJoin('risk_categories as rc_t3', 'rc_t3.id', '=', 'identification.risk_category_t3_id')
            ->leftJoin('scales as i', 'i.id', '=', 'identification.inherent_impact_scale_id')
            ->leftJoin('scales as r1', 'r1.id', '=', 'identification.residual_1_impact_scale_id')
            ->leftJoin('scales as r2', 'r2.id', '=', 'identification.residual_2_impact_scale_id')
            ->leftJoin('scales as r3', 'r3.id', '=', 'identification.residual_3_impact_scale_id')
            ->leftJoin('scales as r4', 'r4.id', '=', 'identification.residual_4_impact_scale_id')
            ->leftJoin('heatmaps as h_i', 'h_i.id', '=', 'identification.inherent_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r1', 'h_r1.id', '=', 'identification.residual_1_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r2', 'h_r2.id', '=', 'identification.residual_2_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r3', 'h_r3.id', '=', 'identification.residual_3_impact_probability_scale_id')
            ->leftJoin('heatmaps as h_r4', 'h_r4.id', '=', 'identification.residual_4_impact_probability_scale_id');
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class, 'worksheet_id');
    }

    public function mitigations()
    {
        return $this->hasMany(WorksheetMitigation::class);
    }

    public function monitoring()
    {
        return $this->hasOne(Monitoring::class, 'worksheet_id', 'worksheet_id');
    }

    public function kri_unit()
    {
        return $this->belongsTo(KRIUnit::class);
    }
}
