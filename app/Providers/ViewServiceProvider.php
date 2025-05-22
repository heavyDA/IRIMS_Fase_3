<?php

namespace App\Providers;

use App\View\Composers\Auth\RoleByUserUnitComposer;
use App\View\Composers\Master\RoleComposer;
use App\View\Composers\MenuComposer;
use App\View\Composers\Master\UnitComposer;
use App\View\Composers\Auth\UserUnitComposer;
use App\View\Composers\Master\FrequencyComposer;
use App\View\Composers\Master\IncidentCategoryComposer;
use App\View\Composers\Master\RiskCategoryComposer;
use App\View\Composers\Master\RiskQualificationComposer;
use App\View\Composers\Risk\RiskMetricComposer;
use App\View\Composers\Risk\WorksheetComposer;
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
        View::composer('layouts.partials.sidebar', RoleByUserUnitComposer::class);
        View::composer('layouts.partials.header', UserUnitComposer::class);

        View::composer([
            'dashboard.index',
            'risk.process.index',
            'risk.assessment.index',
            'risk.top_risk.index',
            'report.risk_monitoring.index',
            'report.risk_profile.index',
            'report.alteration.index',
            'report.loss_event.index',
        ], WorksheetYearComposer::class);

        View::composer([
            'risk.process.index',
            'risk.assessment.index',
            'risk.top_risk.index',
            'report.risk_monitoring.index',
            'report.risk_profile.index',
            'report.alteration.index',
            'report.loss_event.index',
            'RBAC.users.form',
        ], UnitComposer::class);

        View::composer([
            'setting.position.create',
            'setting.position.edit',
        ], RoleComposer::class);

        View::composer([
            'report.alteration.create',
            'report.alteration.edit',
            'report.loss_event.create',
            'report.loss_event.edit',
        ], WorksheetComposer::class);

        View::composer([
            'risk.worksheet.form',
            'risk.assessment.index',
            'risk.process.index',
            'risk.top_risk.index',
            'report.risk_profile.index',
        ], RiskQualificationComposer::class);

        View::composer([
            'report.loss_event.create',
            'report.loss_event.edit',
        ], FrequencyComposer::class);

        View::composer([
            'report.loss_event.create',
            'report.loss_event.edit',
        ], RiskCategoryComposer::class);

        View::composer([
            'report.loss_event.create',
            'report.loss_event.edit',
        ], IncidentCategoryComposer::class);

        View::composer([
            'risk.worksheet.form',
        ], RiskMetricComposer::class);
    }
}
