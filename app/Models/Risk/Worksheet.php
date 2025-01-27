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
