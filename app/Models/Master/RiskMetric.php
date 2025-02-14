<?php

namespace App\Models\Master;

use App\Models\User;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiskMetric extends Model
{
    use SoftDeletes, HasEncryptedId;

    protected $table = 'm_risk_metrics';
    protected $fillable = [
        'organization_code',
        'organization_name',
        'personnel_area_code',
        'personnel_area_name',
        'capacity',
        'appetite',
        'tolerancy',
        'limit',
        'year',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
