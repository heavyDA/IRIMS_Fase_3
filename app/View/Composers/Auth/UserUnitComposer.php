<?php

namespace App\View\Composers\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class UserUnitComposer
{
    public function compose(View $view)
    {
        $units = cache()->remember('current_units.' . auth()->user()->employee_id, now()->addMinutes(5), function () {
            $units = auth()->user()->units()->get();

            return $units->isEmpty() ? null : $units;
        });
        $view->with('current_units', $units ?? collect([]));
    }
}
