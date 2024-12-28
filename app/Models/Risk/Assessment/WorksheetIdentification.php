<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class WorksheetIdentification extends Model
{
    protected $table = 'ra_worksheet_identifications';

    protected $fillable = [
        'worksheet_target_id',
        'kbumn_target_id',
        'risk_category_id',
        'risk_category_t2_id',
        'risk_category_t3_id',
    ];

    public function incidents()
    {
        return $this->hasMany(WorksheetIdentificationIncident::class);
    }
}
