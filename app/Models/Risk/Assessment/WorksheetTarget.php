<?php

namespace App\Models\Risk\Assessment;

use Illuminate\Database\Eloquent\Model;

class WorksheetTarget extends Model
{
    protected $table = 'ra_worksheet_targets';

    protected $fillable = [
        'worksheet_id',
        'body',
    ];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function strategies()
    {
        return $this->hasMany(WorksheetStrategy::class);
    }

    public function identification()
    {
        return $this->hasOne(WorksheetIdentification::class);
    }
}
