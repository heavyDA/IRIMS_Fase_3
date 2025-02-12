<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
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
        $user = auth()->user();
        $role = session()->get('current_role') ?? auth()->user()->roles()->first();
        return DB::table('lower_units as lu')
            ->withExpression(
                'lower_units',
                DB::table('m_officials')
                    ->distinct()
                    ->select('sub_unit_code', 'sub_unit_name', 'personnel_area_code', 'personnel_area_name')
                    ->where(
                        function ($q) use ($role, $unit, $level) {
                            $q->where(
                                fn($q) =>
                                    $q->whereLike('sub_unit_code', $unit)
                                    ->whereRaw("(LENGTH(sub_unit_code) - LENGTH(REPLACE(sub_unit_code, '.', ''))) = ?", $level)
                                )
                                ->when($level > 3, fn($q) => $q->orWhereLike('sub_unit_code', str_replace('.%', '',  $unit)));
                        }
                    )
                    ->when(str_contains($user->personnel_area_code, 'REG '), fn($q) => $q->whereNotLike('personnel_area_code', 'REG %'))
            )
            ->withExpression(
                'monitoring_summary',
                DB::table('ra_monitorings as m')
                    ->selectRaw("
                        lu.sub_unit_code,
                        MONTH(m.period_date) AS month,
                        COUNT(m.id) AS total_monitorings,
                        SUM(CASE WHEN m.status = 'approved' THEN 1 ELSE 0 END) AS approved_monitorings
                    ")
                    ->join('ra_worksheets as w', 'm.worksheet_id', '=', 'w.id')
                    ->join(
                        'lower_units as lu',
                        function ($q) use($role) {
                            $q->on('w.sub_unit_code', 'like', DB::raw("CONCAT(lu.sub_unit_code, '.%')"))
                            ->orWhere('w.sub_unit_code', DB::raw("lu.sub_unit_code"));
                        }
                    )
                    ->whereYear('m.period_date', $year)
                    ->groupBy('lu.sub_unit_code', DB::raw('MONTH(m.period_date)'))
            )
            ->selectRaw("
                lu.sub_unit_code,
                lu.sub_unit_name,
                lu.personnel_area_code,
                lu.personnel_area_name,
                COALESCE(SUM(CASE WHEN ms.month = 1 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 1 THEN ms.total_monitorings END), 0) * 100 AS m1,

                COALESCE(SUM(CASE WHEN ms.month = 2 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 2 THEN ms.total_monitorings END), 0) * 100 AS m2,

                COALESCE(SUM(CASE WHEN ms.month = 3 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 3 THEN ms.total_monitorings END), 0) * 100 AS m3,

                COALESCE(SUM(CASE WHEN ms.month = 4 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 4 THEN ms.total_monitorings END), 0) * 100 AS m4,

                COALESCE(SUM(CASE WHEN ms.month = 5 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 5 THEN ms.total_monitorings END), 0) * 100 AS m5,

                COALESCE(SUM(CASE WHEN ms.month = 6 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 6 THEN ms.total_monitorings END), 0) * 100 AS m6,

                COALESCE(SUM(CASE WHEN ms.month = 7 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 7 THEN ms.total_monitorings END), 0) * 100 AS m7,

                COALESCE(SUM(CASE WHEN ms.month = 8 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 8 THEN ms.total_monitorings END), 0) * 100 AS m8,

                COALESCE(SUM(CASE WHEN ms.month = 9 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 9 THEN ms.total_monitorings END), 0) * 100 AS m9,

                COALESCE(SUM(CASE WHEN ms.month = 10 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 10 THEN ms.total_monitorings END), 0) * 100 AS m10,

                COALESCE(SUM(CASE WHEN ms.month = 11 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 11 THEN ms.total_monitorings END), 0) * 100 AS m11,

                COALESCE(SUM(CASE WHEN ms.month = 12 THEN ms.approved_monitorings END), 0)
                / NULLIF(SUM(CASE WHEN ms.month = 12 THEN ms.total_monitorings END), 0) * 100 AS m12
            ")
            ->leftJoin('monitoring_summary as ms', 'ms.sub_unit_code', '=', 'lu.sub_unit_code')
            ->groupBy('lu.sub_unit_code', 'lu.sub_unit_name', 'lu.personnel_area_code', 'lu.personnel_area_name');
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

    public function residuals()
    {
        return $this->hasMany(MonitoringResidual::class);
    }

    public function residual()
    {
        return $this->hasOne(MonitoringResidual::class)->latest();
    }
}
