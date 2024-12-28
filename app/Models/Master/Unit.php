<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'mst_units';

    protected $fillable = [
        'code',
        'name',
        'address',
        'village',
        'district',
        'city',
        'province',
        'country',
        'phone',
        'fax',
        'mobile_phone',
        'email',
        'description',
        'is_head_office',
        'is_active',
        'lat',
        'lon',
        'mst_unit_id',
        'show_in_dashboard',
        'sorting',
        'created_by',
        'updated_by',
    ];
}
