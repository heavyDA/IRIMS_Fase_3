<?php

namespace App\Models\Risk;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorksheetTopRisk extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_top_risks';

    protected $fillable = [
        'worksheet_id',
        'sub_unit_code',
        'source_sub_unit_code',
    ];

    public static function top_risk_query(?string $unit = null)
    {
        return DB::table('worksheets as w')
            ->withExpression(
                'worksheets',
                WorksheetIncident::incident_query()
            )
            ->selectRaw('
                w.*,
                rq.name as risk_qualification_name,
                tp.sub_unit_code as destination_sub_unit_code,
                tp.source_sub_unit_code,

                tp.id as top_risk_id
            ')
            ->leftJoin('ra_worksheet_top_risks as tp', 'tp.worksheet_id', '=', 'w.worksheet_id')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id');
        // ->rightJoin(
        //     'ra_worksheet_top_risks as tp_submit',
        //     fn($q) => $q->on('tp_submit.worksheet_id', '=', 'w.worksheet_id')
        //         ->when($unit, fn($q) => $q->where('tp.source_sub_unit_code', $unit))
        // );
    }

    public static function top_risk_destination_query($unit)
    {
        return DB::table('worksheets as w')
            ->withExpression(
                'worksheets',
                WorksheetIncident::incident_query()
            )
            ->selectRaw('
                w.*,
                rq.name as risk_qualification_name,
                tp.sub_unit_code as destination_sub_unit_code,
                tp.source_sub_unit_code,

                tp.id as top_risk_id
            ')
            ->leftJoin(
                'ra_worksheet_top_risks as tp',
                fn($q) => $q->on('tp.worksheet_id', '=', 'w.worksheet_id')
                    ->where('tp.source_sub_unit_code', $unit)
            )
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'w.risk_qualification_id');
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }
}
