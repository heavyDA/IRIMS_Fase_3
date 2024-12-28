<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class ControlEffectivenessAssessment extends Model
{
    protected $table = 'm_control_effectiveness_assessments';

    protected $fillable = [
        'name',
    ];
}
