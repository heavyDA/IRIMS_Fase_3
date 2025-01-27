<?php

namespace App\Providers;

use App\View\Composers\MenuComposer;
use App\View\Composers\Master\UnitComposer;
use App\View\Composers\Risk\WorksheetYearComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.sidebar', MenuComposer::class);

        View::composer([
            'risk.process.index',
            'report.risk_monitoring.index',
        ], WorksheetYearComposer::class);
        View::composer([
            'risk.process.index',
            'report.risk_monitoring.index',
        ], UnitComposer::class);
    }
}
