<?php

namespace App\Models\Risk;

use App\Models\Master\BUMNScale;
use App\Models\Master\ControlEffectivenessAssessment;
use App\Models\Master\ExistingControlType;
use App\Models\Master\Heatmap;
use App\Models\Master\KBUMNRiskCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorksheetIdentification extends Model
{
    protected $table = 'ra_worksheet_identifications';

    protected $fillable = [
        'worksheet_id',
        'company_name',
        'company_code',
        'risk_category_t2_id',
        'risk_category_t3_id',
        'existing_control_type_id',
        'existing_control_body',
        'control_effectiveness_assessment_id',

        'risk_impact_category',
        'risk_impact_body',
        'risk_impact_start_date',
        'risk_impact_end_date',

        'inherent_body',
        'inherent_impact_value',
        'inherent_impact_scale_id',
        'inherent_impact_probability',
        'inherent_impact_probability_scale_id',
        'inherent_risk_exposure',
        'inherent_risk_level',
        'inherent_risk_scale',

        'residual_1_impact_value',
        'residual_1_impact_scale_id',
        'residual_1_impact_probability',
        'residual_1_impact_probability_scale_id',
        'residual_1_risk_exposure',
        'residual_1_risk_level',
        'residual_1_risk_scale',
        'residual_2_impact_value',
        'residual_2_impact_scale_id',
        'residual_2_impact_probability',
        'residual_2_impact_probability_scale_id',
        'residual_2_risk_exposure',
        'residual_2_risk_level',
        'residual_2_risk_scale',
        'residual_3_impact_value',
        'residual_3_impact_scale_id',
        'residual_3_impact_probability',
        'residual_3_impact_probability_scale_id',
        'residual_3_risk_exposure',
        'residual_3_risk_level',
        'residual_3_risk_scale',
        'residual_4_impact_value',
        'residual_4_impact_scale_id',
        'residual_4_impact_probability',
        'residual_4_impact_probability_scale_id',
        'residual_4_risk_exposure',
        'residual_4_risk_level',
        'residual_4_risk_scale',
    ];

    protected $with = [];

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

    public static function identification_query()
    {
        return DB::table('ra_worksheet_identifications as identification')
            ->select(
                'identification.*',
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
            )
            ->withExpression('scales', DB::table('m_bumn_scales'))
            ->withExpression('heatmaps', DB::table('m_heatmaps'))
            ->withExpression('risk_categories', DB::table('m_kbumn_risk_categories'))
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

    public function incidents()
    {
        return $this->hasMany(WorksheetIncident::class);
    }

    public function worksheet(): BelongsTo
    {
        return $this->belongsTo(Worksheet::class);
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
