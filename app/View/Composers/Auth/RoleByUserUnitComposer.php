<?php

namespace App\View\Composers\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class RoleByUserUnitComposer
{
    public function compose(View $view)
    {
        $roles = cache()->remember('current_roles.' . auth()->user()->employee_id, now()->addMinutes(5), function () {
            return null;
            // $roles = session()->get('current_unit')->roles()->get();
            // return $roles->isEmpty() ? null : $roles;
        });
        $view->with('current_roles', $roles ?? collect([]));
    }
}
