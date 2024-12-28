<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class ExistingControlType extends Model
{
    protected $table = 'm_existing_control_types';

    protected $fillable = [
        'name',
    ];
}
