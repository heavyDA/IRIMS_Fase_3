<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KRIThreshold extends Model
{
    protected $table = 'm_kri_thresholds';

    protected $fillable = [
        'name',
    ];
}
