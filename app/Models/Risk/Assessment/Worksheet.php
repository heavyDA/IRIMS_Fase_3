<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    protected $table = 'ra_worksheets';

    protected $fillable = [
        'worksheet_code',
        'work_unit_code',
        'work_unit_name',
        'work_sub_unit_code',
        'work_sub_unit_name',
        'organization_code',
        'organization_name',
        'personal_area_code',
        'personal_area_name',
        'status',
    ];

    public function scopeActiveYear($query, $year = null)
    {
        return $query->whereYear('created_at', $year ?? date('Y'));
    }

    public function target()
    {
        return $this->hasOne(WorksheetTarget::class);
    }
}
