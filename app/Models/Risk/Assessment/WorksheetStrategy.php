<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class WorksheetStrategy extends Model
{
    protected $table = 'ra_worksheet_strategies';

    protected $fillable = [
        'worksheet_target_id',
        'body',
        'expected_feedback',
        'risk_value',
        'risk_value_limit',
        'decision',
    ];

    public function target()
    {
        return $this->belongsTo(WorksheetTarget::class, 'worksheet_target_id');
    }
}
