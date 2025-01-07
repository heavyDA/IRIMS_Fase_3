<?php

namespace App\Models\Risk\Assessment;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Worksheet extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheets';

    protected $fillable = [
        'worksheet_code',
        'worksheet_number',
        'unit_code',
        'unit_name',
        'sub_unit_code',
        'sub_unit_name',
        'organization_code',
        'organization_name',
        'personnel_area_code',
        'personnel_area_name',
        'company_code',
        'company_name',
        'status',
    ];


    public function scopeActiveYear($query, $year = null)
    {
        return $query->whereYear('created_at', $year ?? date('Y'));
    }

    public function scopeSubUnit($query, $sub_unit_code)
    {
        return $query->where('sub_unit_code', $sub_unit_code);
    }

    protected function periodDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->format('M d, Y'),
        );
    }

    protected function periodYear(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at->format('Y'),
        );
    }

    public function target()
    {
        return $this->hasOne(WorksheetTarget::class);
    }

    public function last_history()
    {
        return $this->hasOne(WorksheetHistory::class)->latest();
    }

    public function histories()
    {
        return $this->hasMany(WorksheetHistory::class)->latest();
    }
}
