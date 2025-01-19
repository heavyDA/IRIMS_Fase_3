<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Model;

class MonitoringAlteration extends Model
{
    protected $table = 'ra_monitoring_alterations';
    protected $fillable = [
        'monitoring_id',
        'body',
        'impact',
        'description',
    ];
}
