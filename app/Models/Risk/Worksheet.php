<?php

namespace App\Models\Risk;

use App\Enums\DocumentStatus;
use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

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
        'target_body',
        'status',
        'status_monitoring',
    ];

    public function scopeActiveYear($query, $year = null)
    {
        return $query->whereYear('created_at', $year ?? date('Y'));
    }

    public function scopeSubUnit($query, $sub_unit_code)
    {
        $role = session()->get('current_role')?->name;
        if (in_array($role, ['risk admin', 'risk owner'])) {
            return $query->where('sub_unit_code', $sub_unit_code);
        } else if (in_array($role, ['risk otorisator', 'risk analis'])) {
            return $query->where('sub_unit_code', 'like', $sub_unit_code . '%');
        }
    }

    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = DocumentStatus::tryFrom($this->attributes['status']);
                $label = $status->label();
                $color = $status->color();
                return view('components.badge', compact('label', 'color'));
            }
        );
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

    public function strategies()
    {
        return $this->hasMany(WorksheetStrategy::class);
    }

    public function identification()
    {
        return $this->hasOne(WorksheetIdentification::class);
    }


    public function incidents()
    {
        return $this->hasMany(WorksheetIncident::class);
    }


    public function last_history()
    {
        return $this->hasOne(WorksheetHistory::class)->latest();
    }

    public function histories()
    {
        return $this->hasMany(WorksheetHistory::class)->latest();
    }

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }
}
