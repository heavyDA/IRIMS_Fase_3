<?php

namespace App\Models\Master;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class KBUMNRiskCategory extends Model
{
    use HasEncryptedId;
    protected $table = 'm_kbumn_risk_categories';

    protected $fillable = [
        'type',
        'name',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
