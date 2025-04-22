<?php

namespace App\View\Composers\Master;

use App\Models\Master\IncidentCategory;
use Illuminate\View\View;

class IncidentCategoryComposer
{
    public function compose(View $view)
    {
        $view->with('incident_categories', IncidentCategory::all());
    }
}
