<?php

namespace App\Models\Master;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class RiskTreatmentType extends Model
{
    use HasEncryptedId;
    protected $table = 'm_risk_treatment_types';
    protected $fillable = ['parent_id', 'number', 'name'];
}
