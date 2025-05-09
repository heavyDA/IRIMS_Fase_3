<?php

namespace App\View\Composers\Master;

use App\Models\Master\RiskQualification;
use Illuminate\View\View;

class RiskQualificationComposer
{
    public function compose(View $view)
    {
        $view->with(
            'risk_qualifications',
            RiskQualification::all()
        );
    }
}
