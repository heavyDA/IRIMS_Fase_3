<?php

namespace App\Models\ACL;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    public function scopeIgnoreRoot($query)
    {
        return $query->where('name', '!=', 'root');
    }
}
