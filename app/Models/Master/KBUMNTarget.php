<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class KBUMNTarget extends Model
{
    protected $table = 'm_kbumn_targets';

    protected $fillable = [
        'name',
    ];
}
