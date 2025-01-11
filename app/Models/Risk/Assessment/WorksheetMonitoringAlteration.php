<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class WorksheetMonitoringAlteration extends Model
{
    protected $table = 'ra_worksheet_monitoring_alterations';
    protected $fillable = [
        'worksheet_monitoring_id',
        'body',
        'impact',
        'description',
    ];
}
