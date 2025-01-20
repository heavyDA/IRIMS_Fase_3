<?php

namespace App\Models\Risk;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class WorksheetTopRisk extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_top_risks';

    protected $fillable = [
        'worksheet_id',
        'sub_unit_code',
        'source_sub_unit_code',
    ];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }
}
