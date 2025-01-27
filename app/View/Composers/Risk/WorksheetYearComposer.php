<?php

namespace App\View\Composers\Risk;

use App\Models\Risk\Worksheet;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class WorksheetYearComposer
{
    public function compose(View $view)
    {
        $worksheet_years = Cache::remember(
            'risk.worksheet.years',
            now()->addHours(1),
            fn() => Worksheet::selectRaw('DISTINCT YEAR(created_at) AS year')
                ->orderBy('year', 'desc')
                ->get()
        );

        if ($worksheet_years->isEmpty()) {
            $worksheet_years = collect([['year' => date('Y')]]);
        }

        $view->with('worksheet_years', $worksheet_years);
    }
}
