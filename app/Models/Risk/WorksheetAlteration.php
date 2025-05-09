<?php

namespace App\Models\Risk;

use App\Models\Master\Position;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WorksheetAlteration extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_alterations';
    protected $fillable = [
        'worksheet_id',
        'body',
        'impact',
        'description',
        'created_by',
    ];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }

    /**
     * @param ?string $unit default '-'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getAlterations(?string $unit = '-')
    {
        return DB::table('ra_worksheet_alterations')
            ->select(
                'ra_worksheet_alterations.id',
                'body',
                'impact',
                'description',
                'ph.sub_unit_code_doc',
                'ph.sub_unit_name',
                'ra_worksheets.target_body',
                'ra_worksheets.worksheet_number',
                'rq.name as risk_qualification_name',
                'users.employee_name',
                'ra_worksheet_alterations.created_by',
                'ra_worksheet_alterations.created_at',
            )
            ->withExpression(
                'ph',
                Position::hierarchyQuery($unit)
            )
            ->join('ra_worksheets', 'ra_worksheet_alterations.worksheet_id', 'ra_worksheets.id')
            ->join('ph', 'ph.sub_unit_code', 'ra_worksheets.sub_unit_code')
            ->leftJoin('m_risk_qualifications as rq', 'rq.id', '=', 'ra_worksheets.risk_qualification_id')
            ->leftJoin('users', 'ra_worksheet_alterations.created_by', 'users.employee_id');
    }
}
