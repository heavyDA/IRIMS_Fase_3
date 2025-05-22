<?php

namespace App\Models\Master;

use App\Models\User;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class RiskQualification extends Model
{
    use HasEncryptedId;

    protected $table = 'm_risk_qualifications';

    protected $fillable = [
        'name',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
