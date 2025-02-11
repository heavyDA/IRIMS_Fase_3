<?php

namespace App\Models\Master;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class ExistingControlType extends Model
{
    use HasEncryptedId;
    protected $table = 'm_existing_control_types';

    protected $fillable = [
        'name',
    ];
}
