<?php

namespace App\Models\Risk;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WorksheetAlteration extends Model
{
    use HasEncryptedId;

    protected $table = 'ra_worksheet_alterations';
    protected $fillable = [
        'worksheet_id',
        'body',
        'impact',
        'description',
        'created_by',
    ];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'employee_id');
    }
}
