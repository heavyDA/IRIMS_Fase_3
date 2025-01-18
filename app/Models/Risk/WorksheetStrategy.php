<?php

namespace App\Models\Risk;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class WorksheetStrategy extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_strategies';

    protected $fillable = [
        'worksheet_id',
        'body',
        'expected_feedback',
        'risk_value',
        'risk_value_limit',
        'decision',
    ];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }
}
