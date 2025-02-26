<?php

namespace App\View\Composers\Master;

use App\Models\RBAC\Role;
use Illuminate\View\View;

class RoleComposer
{
    public function compose(View $view)
    {
        $roles = Role::whereNotIn('name', ['administrator', 'root'])->get();
        $view->with('roles', $roles);
    }
}
