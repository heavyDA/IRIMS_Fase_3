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
            $worksheet_years = collect([(object) ['year' => date('Y')]]);
        }

        $months = array_map(
            fn($month) => format_date("2000-$month-01")->translatedFormat('F'),
            range(1, 12)
        );

        $view->with([
            'worksheet_years' => $worksheet_years,
            'worksheet_months' => $months,
        ]);
    }
}
