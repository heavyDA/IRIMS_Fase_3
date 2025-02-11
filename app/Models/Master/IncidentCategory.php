<?php

namespace App\Models\Master;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class IncidentCategory extends Model
{
    use HasEncryptedId;

    protected $table = 'm_incident_categories';
    protected $fillable = ['name',];
}
