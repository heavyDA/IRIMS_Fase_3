<?php

namespace App\View\Composers\Master;

use App\Models\Master\KBUMNRiskCategory;
use Illuminate\View\View;

class RiskCategoryComposer
{
    public function compose(View $view)
    {
        $view->with(
            'risk_categories',
            KBUMNRiskCategory::with('children')
                ->whereNull('parent_id')
                ->get()
        );
    }
}
