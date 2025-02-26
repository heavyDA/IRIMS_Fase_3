<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Models\Master\Position;
use App\Models\RBAC\Role;
use App\Traits\HasEncryptedId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monitoring extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_monitorings';

    protected $fillable = [
        'worksheet_id',
        'period_date',
        'created_by',
        'status',
    ];

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

    protected function statusTableAction(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $status = DocumentStatus::tryFrom($this->attributes['status']);
                $class = $status->color();
                $route = route('risk.monitoring.show_monitoring', $this->getEncryptedId());
                $key = $this->attributes['id'];

                return view('risk.monitoring._table_status', compact('status', 'class', 'route', 'key'));
            },
        );
    }

    protected function periodDateFormat(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>  Carbon::parse($this->attributes['period_date']),
        );
    }

    public static function latest_monitoring_query()
    {
        return DB::table('ra_monitorings as m')
            ->selectRaw('m.*')
            ->joinSub(
                DB::table('ra_monitorings')
                    ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                    ->groupBy('worksheet_id'),
                'latest',
                function ($join) {
                    $join->on('m.worksheet_id', '=', 'latest.worksheet_id');
                    $join->on('m.period_date', '=', 'latest.period_date');
                }
            );
    }

    public static function monitoring_progress_each_unit_query(string $unit, int $level, int $year)
    {
        return DB::table(app(Position::class)->getTable(), 'p')
            ->withExpression(
                'position_hierarchy',
                Position::hierarchyQuery($unit)
            )
            ->withExpression(
                'existing_worksheets',
                DB::table('ra_worksheets as w')
                    ->selectRaw('
                        w.sub_unit_code,
                        GROUP_CONCAT(w.id) as worksheet_ids,
                        COUNT(w.id) as total_worksheets
                    ')
                    ->leftJoin('position_hierarchy as ph', 'w.sub_unit_code', '=', 'ph.sub_unit_code')
                    ->whereYear('w.created_at', $year)
                    ->groupBy('w.sub_unit_code')
            )
            ->withExpression(
                'monitoring_summary',
                DB::table('existing_worksheets as w')
                    ->selectRaw("
                        w.sub_unit_code,
                        MONTH(m.period_date) AS month,
                        w.total_worksheets,
                        SUM(CASE WHEN m.status = 'approved' THEN 1 ELSE 0 END) AS approved_monitorings
                    ")
                    ->leftJoin('ra_monitorings as m', DB::raw('FIND_IN_SET(m.worksheet_id, w.worksheet_ids)'), '>', DB::raw('0'))
                    ->groupBy('w.sub_unit_code', DB::raw('MONTH(m.period_date)'))
            )
            ->selectRaw("
                p.branch_code,
                p.sub_unit_code,
                p.sub_unit_name,
                COALESCE(SUM(CASE WHEN ms.month = 1 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 1 THEN ms.total_worksheets END), 0) * 100 AS m1,

                COALESCE(SUM(CASE WHEN ms.month = 2 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 2 THEN ms.total_worksheets END), 0) * 100 AS m2,

                COALESCE(SUM(CASE WHEN ms.month = 3 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 3 THEN ms.total_worksheets END), 0) * 100 AS m3,

                COALESCE(SUM(CASE WHEN ms.month = 4 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 4 THEN ms.total_worksheets END), 0) * 100 AS m4,

                COALESCE(SUM(CASE WHEN ms.month = 5 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 5 THEN ms.total_worksheets END), 0) * 100 AS m5,

                COALESCE(SUM(CASE WHEN ms.month = 6 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 6 THEN ms.total_worksheets END), 0) * 100 AS m6,

                COALESCE(SUM(CASE WHEN ms.month = 7 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 7 THEN ms.total_worksheets END), 0) * 100 AS m7,

                COALESCE(SUM(CASE WHEN ms.month = 8 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 8 THEN ms.total_worksheets END), 0) * 100 AS m8,

                COALESCE(SUM(CASE WHEN ms.month = 9 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 9 THEN ms.total_worksheets END), 0) * 100 AS m9,

                COALESCE(SUM(CASE WHEN ms.month = 10 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 10 THEN ms.total_worksheets END), 0) * 100 AS m10,

                COALESCE(SUM(CASE WHEN ms.month = 11 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 11 THEN ms.total_worksheets END), 0) * 100 AS m11,

                COALESCE(SUM(CASE WHEN ms.month = 12 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 12 THEN ms.total_worksheets END), 0) * 100 AS m12
            ")
            ->leftJoin('monitoring_summary as ms', 'ms.sub_unit_code', '=', 'p.sub_unit_code')
            // ->whereRaw('p.unit_code IN (select sub_unit_code from position_hierarchy)')
            ->where('p.unit_code', $unit)
            ->groupBy('p.sub_unit_code', 'ms.month')
            ->orderBy('p.sub_unit_code', 'asc');
    }

    public static function scopeGetMonitoringByStatus($query)
    {
        $table = app(self::class)->getTable();
        return $query->selectRaw('
            COUNT(IF(ma.actualization_plan_status <> "discontinue", 1, NULL)) as progress,
            COUNT(IF(ma.actualization_plan_status = "discontinue", 1, NULL)) as finished
        ')
            ->joinSub(
                DB::table($table)
                    ->select('worksheet_id', DB::raw('MAX(period_date) as period_date'))
                    ->groupBy('worksheet_id'),
                'latest',
                fn($join) =>
                $join->on("{$table}.worksheet_id", '=', 'latest.worksheet_id')
                    ->on("{$table}.period_date", '=', 'latest.period_date')
            )
            ->leftJoin('ra_worksheets as w', 'w.id', '=', "{$table}.worksheet_id")
            ->leftJoin('ra_monitoring_actualizations as ma', 'ma.monitoring_id', '=', "{$table}.id")
            ->groupBy("{$table}.id");
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function histories()
    {
        return $this->hasMany(MonitoringHistory::class)->latest();
    }

    public function last_history()
    {
        return $this->hasOne(MonitoringHistory::class)->latest();
    }

    public function alteration()
    {
        return $this->hasOne(MonitoringAlteration::class);
    }

    public function actualizations()
    {
        return $this->hasMany(MonitoringActualization::class);
    }

    public function incident()
    {
        return $this->hasOne(MonitoringIncident::class);
    }

    public function residual()
    {
        return $this->hasOne(MonitoringResidual::class);
    }
}
