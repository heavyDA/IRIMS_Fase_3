<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Master\{
    BUMNScaleController,
    ExistingControlTypeController,
    HeatmapController,
    IncidentCategoryController,
    KBUMNRiskCategoryController,
    PICController,
    RiskMetricsController,
    RiskTreatmentOptionController,
    RiskTreatmentTypeController
};
use App\Http\Controllers\Report\AlterationController;
use App\Http\Controllers\Report\LossEventController;
use App\Http\Controllers\Report\RiskProfileController;
use App\Http\Controllers\Report\RiskMonitoringController;
use App\Http\Controllers\Risk\AssessmentController;
use App\Http\Controllers\Risk\MonitoringController;
use App\Http\Controllers\Risk\TopRiskController;
use App\Http\Controllers\Risk\WorksheetController;
use App\Http\Controllers\Setting\PositionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login', 'as' => 'auth.', 'middleware' => 'guest'], function () {
    Route::get('', [AuthController::class, 'index'])->name('login');
    Route::post('', [AuthController::class, 'authenticate'])->name('authenticate');
});
Route::group(['middleware' => 'auth'], function () {
    Route::post('change-role', [AuthController::class, 'change_role'])->name('change_role');
    Route::post('change-unit', [AuthController::class, 'change_unit'])->name('change_unit');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::delete('', [AuthController::class, 'unauthenticate'])->name('auth.unauthenticate');


    Route::group(['prefix' => 'analytics', 'as' => 'analytics.'], function () {
        Route::get('get-monitoring-progress', [DashboardController::class, 'get_monitoring_progress'])->name('get_monitoring_progress');
        Route::get('inherent-risk-scale', [DashboardController::class, 'inherent_risk_scale'])->name('inherent_risk_scale');
        Route::get('target-residual-risk-scale', [DashboardController::class, 'target_residual_risk_scale'])->name('target_residual_risk_scale');
        Route::get('residual-risk-scale', [DashboardController::class, 'residual_risk_scale'])->name('residual_risk_scale');
        Route::get('monitoring-progress-child', [DashboardController::class, 'monitoring_progress_child'])->name('monitoring_progress_child');
    });

    Route::get('profile/unit_head', [AuthController::class, 'get_unit_head'])->name('profile.get_unit_head');
    Route::get('profile/unit-heads', [AuthController::class, 'get_unit_heads'])->name('profile.get_unit_heads');
    Route::get('profile/risk_metric', [AuthController::class, 'get_risk_metric'])->name('profile.get_risk_metric');

    Route::group(['as' => 'risk.', 'prefix' => 'risk-process'], function () {
        Route::group(['as' => 'worksheet.', 'prefix' => 'worksheet'], function () {
            Route::get('', [WorksheetController::class, 'index'])->name('index');
            Route::get('get-by-inherent-risk-scale/{inherentScale}', [WorksheetController::class, 'get_by_inherent_risk_scale'])->name('get_by_inherent_risk_scale');
            Route::get('get-by-target-risk-scale/{inherentScale}', [WorksheetController::class, 'get_by_target_risk_scale'])->name('get_by_target_risk_scale');
            Route::get('get-by-actualization-risk-scale/{inherentScale}', [WorksheetController::class, 'get_by_actualization_risk_scale'])->name('get_by_actualization_risk_scale');
            Route::post('', [WorksheetController::class, 'store'])->name('store');


            Route::get('{worksheet}', [WorksheetController::class, 'show'])->name('show');
            Route::get('{worksheet}/edit', [WorksheetController::class, 'edit'])->name('edit');
            Route::put('{worksheet}/edit', [WorksheetController::class, 'update'])->name('update');
            Route::put('{worksheet}/status', [WorksheetController::class, 'update_status'])->name('update_status');
            Route::delete('{worksheet}', [WorksheetController::class, 'destroy'])->name('destroy');
        });

        Route::group(['as' => 'monitoring.', 'prefix' => 'monitoring'], function () {
            Route::get('', [MonitoringController::class, 'index'])->name('index');
            Route::get('{worksheet}', [MonitoringController::class, 'show'])->name('show');
            Route::get('{worksheet}/create', [MonitoringController::class, 'create'])->name('create');
            Route::post('{worksheet}/create', [MonitoringController::class, 'store'])->name('store');
            Route::get('detail/{monitoringId}', [MonitoringController::class, 'show_monitoring'])->name('show_monitoring');
            Route::get('detail/{monitoringId}/edit', [MonitoringController::class, 'edit_monitoring'])->name('edit_monitoring');
            Route::put('detail/{monitoringId}/edit', [MonitoringController::class, 'update_monitoring'])->name('update_monitoring');
            Route::put('status/{monitoringId}', [MonitoringController::class, 'update_status_monitoring'])->name('update_status_monitoring');
            Route::delete('detail/{monitoringId}/delete', [MonitoringController::class, 'destroy_monitoring'])->name('destroy_monitoring');
        });

        Route::group(['as' => 'top_risk.', 'prefix' => 'top-risk'], function () {
            Route::get('', [TopRiskController::class, 'index'])->name('index');
            Route::post('', [TopRiskController::class, 'store'])->name('store');

            Route::get('get-for-dashboard', [TopRiskController::class, 'get_for_dashboard'])->name('get_for_dashboard');
        });


        Route::resource(
            'assessment',
            AssessmentController::class,
            [
                'names' => custom_route_names('assessment'),
                'parameters' => ['assessment' => 'assessment']
            ]
        );
    });

    Route::group(['as' => 'risk.report.', 'prefix' => 'risk-report'], function () {
        Route::group(['as' => 'risk_profile.', 'prefix' => 'risk-profile'], function () {
            Route::get('', [RiskProfileController::class, 'index'])->name('index');
            Route::get('export', [RiskProfileController::class, 'export'])->name('export');
        });

        Route::group(['as' => 'risk_monitoring.', 'prefix' => 'risk-monitoring'], function () {
            Route::get('', [RiskMonitoringController::class, 'index'])->name('index');
            Route::get('export', [RiskMonitoringController::class, 'export'])->name('export');
        });

        Route::get('alterations/export', [AlterationController::class, 'export'])->name('alterations.export');
        Route::resource('alterations', AlterationController::class, ['names' => custom_route_names('alterations')])->except(['show']);
        Route::get('loss-events/export', [LossEventController::class, 'export'])->name('loss_events.export');
        Route::resource('loss-events', LossEventController::class, ['names' => custom_route_names('loss_events')])->except(['show']);
    });

    Route::group(['as' => 'master.', 'prefix' => 'master'], function () {
        Route::resource(
            'scales',
            BUMNScaleController::class,
            [
                'names' => custom_route_names('bumn_scales'),
                'parameters' => ['bumn_scales' => 'bumn_scale'],
            ]
        );
        Route::resource(
            'existing-control-types',
            ExistingControlTypeController::class,
            [
                'names' => custom_route_names('existing_control_types'),
                'parameters' => ['existing_control_types' => 'existing_control_type'],
            ]
        );
        Route::resource(
            'incident-categories',
            IncidentCategoryController::class,
            [
                'names' => custom_route_names('incident_categories'),
                'parameters' => ['incident_categories' => 'incident_category'],
            ]
        );
        Route::resource(
            'risk-categories',
            KBUMNRiskCategoryController::class,
            [
                'names' => custom_route_names('risk_categories'),
                'parameters' => ['risk_categories' => 'risk_category'],
            ]
        );
        Route::resource(
            'risk-treatment-types',
            RiskTreatmentTypeController::class,
            [
                'names' => custom_route_names('risk_treatment_types'),
                'parameters' => ['risk_treatment_types' => 'risk_treatment_type'],
            ]
        );
        Route::resource(
            'risk-treatment-options',
            RiskTreatmentOptionController::class,
            [
                'names' => custom_route_names('risk_treatment_options'),
                'parameters' => ['risk_treatment_options' => 'risk_treatment_option'],
            ]
        );

        Route::get('data/risk-categories', [KBUMNRiskCategoryController::class, 'get_all']);
        Route::get('data/bumn-scales', [BUMNScaleController::class, 'get_all']);
        Route::get('data/heatmaps', [HeatmapController::class, 'get_all']);
        Route::get('data/pics', [PICController::class, 'get_all']);

        Route::resource(
            'pic',
            PICController::class,
            [
                'names' => custom_route_names('pic'),
                'parameters' => ['pic' => 'pic']
            ]
        );
    });

    Route::group(['as' => 'setting.', 'prefix' => 'setting'], function () {
        Route::resource(
            'matriks-strategi-risiko',
            RiskMetricsController::class,
            [
                'names' => custom_route_names('risk_metrics'),
                'parameters' => ['risk_metric' => 'risk_metric'],
            ]
        );

        Route::get('positions/all', [PositionController::class, 'get_all'])->name('positions.all');
        Route::resource(
            'positions',
            PositionController::class,
            [
                'names' => custom_route_names('positions'),
                'parameters' => ['positions' => 'position'],
            ]
        );
    });

    Route::group(['as' => 'rbac.', 'prefix' => 'access'], function () {
        Route::resource(
            'users',
            App\Http\Controllers\RBAC\UserController::class,
            [
                'names' => custom_route_names('users'),
                'parameters' => ['users' => 'user']
            ]
        );
    });

    Route::get('file/{key}', [FileController::class, 'serve'])->name('file.serve');
});
