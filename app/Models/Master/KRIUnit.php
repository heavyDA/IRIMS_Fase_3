<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KRIUnit extends Model
{
    protected $table = 'm_kri_units';

    protected $fillable = [
        'name',
    ];
}
