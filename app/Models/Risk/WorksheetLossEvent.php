<?php

namespace App\Models\Risk;

use App\Models\Master\IncidentCategory;
use App\Models\Master\IncidentFrequency;
use App\Models\Master\KBUMNRiskCategory;
use App\Models\Master\Position;
use App\Models\User;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorksheetLossEvent extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_loss_events';
    protected $fillable = [
        'worksheet_id',
        'incident_body',
        'incident_date',
        'incident_source',
        'incident_handling',
        'risk_category_t2_id',
        'risk_category_t3_id',
        'loss_value',
        'related_party',
        'restoration_status',
        'insurance_status',
        'insurance_permit',
        'insurance_claim',
        'created_by',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
    ];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class, 'worksheet_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }

    public function risk_category_t2()
    {
        return $this->belongsTo(KBUMNRiskCategory::class, 'risk_category_t2_id', 'id');
    }

    public function risk_category_t3()
    {
        return $this->belongsTo(KBUMNRiskCategory::class, 'risk_category_t3_id', 'id');
    }

    public static function getLossEvents(?string $unit = '-')
    {
        return DB::table('ra_worksheet_loss_events')
            ->withExpression(
                'ph',
                Position::hierarchyQuery($unit)
            )
            ->select(
                'ra_worksheet_loss_events.id',
                'ra_worksheet_loss_events.incident_body',
                'ra_worksheet_loss_events.incident_date',
                'ra_worksheet_loss_events.incident_source',
                'ra_worksheet_loss_events.incident_handling',
                'risk_categories_t2.name as risk_category_t2_name',
                'risk_categories_t3.name as risk_category_t3_name',
                'ra_worksheet_loss_events.loss_value',
                'ra_worksheet_loss_events.related_party',
                'ra_worksheet_loss_events.restoration_status',
                'ra_worksheet_loss_events.insurance_status',
                'ra_worksheet_loss_events.insurance_permit',
                'ra_worksheet_loss_events.insurance_claim',
                'ph.sub_unit_code_doc',
                'ph.sub_unit_name',
                'ra_worksheets.target_body',
                'ra_worksheets.worksheet_number',
                'users.employee_name',
                'ra_worksheet_loss_events.created_by',
                'ra_worksheet_loss_events.created_at',
            )
            ->join('ra_worksheets', 'ra_worksheet_loss_events.worksheet_id', 'ra_worksheets.id')
            ->join('ph', 'ph.sub_unit_code', 'ra_worksheets.sub_unit_code')
            ->leftJoin('m_kbumn_risk_categories as risk_categories_t2', 'ra_worksheet_loss_events.risk_category_t2_id', 'risk_categories_t2.id')
            ->leftJoin('m_kbumn_risk_categories as risk_categories_t3', 'ra_worksheet_loss_events.risk_category_t3_id', 'risk_categories_t3.id')
            ->leftJoin('users', 'ra_worksheet_loss_events.created_by', 'users.employee_id');
    }
}
