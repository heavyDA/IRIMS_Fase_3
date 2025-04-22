<?php

namespace App\Providers;

use App\Models\Risk\WorksheetAlteration;
use App\Models\Risk\WorksheetLossEvent;
use App\Policies\Risk\WorksheetAlterationPolicy;
use App\Policies\Risk\WorksheetLossEventPolicy;
use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RoleService::class, function ($app) {
            return new RoleService($app->make(SessionManager::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('root') || $user->hasRole('administrator') ? true : null;
        });

        Gate::policy(WorksheetAlteration::class, WorksheetAlterationPolicy::class);
        Gate::policy(WorksheetLossEvent::class, WorksheetLossEventPolicy::class);

        setlocale(LC_ALL, 'id_ID');
        Carbon::setLocale('id');
    }
}
