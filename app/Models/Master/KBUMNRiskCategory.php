<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KBUMNRiskCategory extends Model
{
    protected $table = 'm_kbumn_risk_categories';

    protected $fillable = [
        'type',
        'name',
    ];
}
