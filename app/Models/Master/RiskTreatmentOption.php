<?php

namespace App\Models\Master;

use App\Models\User;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class RiskTreatmentOption extends Model
{
    use HasEncryptedId;
    protected $table = 'm_risk_treatment_options';
    protected $fillable = ['name',];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
