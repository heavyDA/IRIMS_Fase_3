<?php

namespace App\View\Composers\Master;

use App\Models\Master\IncidentFrequency;
use Illuminate\View\View;

class FrequencyComposer
{
    public function compose(View $view)
    {
        $view->with('frequencies', IncidentFrequency::all());
    }
}
