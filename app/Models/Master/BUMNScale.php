<?php

namespace App\Models\Master;

use App\Traits\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class BUMNScale extends Model
{
    use HasEncryptedId;

    protected $table = 'm_bumn_scales';
    protected $fillable = ['impact_category', 'scale', 'criteria', 'description', 'min', 'max',];
}
