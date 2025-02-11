<?php

namespace App\Models\Master;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class RiskTreatmentOption extends Model
{
    use HasEncryptedId;
    protected $table = 'm_risk_treatment_options';
    protected $fillable = ['name',];
}
