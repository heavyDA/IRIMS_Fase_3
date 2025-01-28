<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\{
    BUMNScaleController,
    ExistingControlTypeController,
    HeatmapController,
    KBUMNRiskCategoryController,
    KRIUnitController,
    PICController
};
use App\Http\Controllers\Report\RiskProfileController;
use App\Http\Controllers\Report\RiskMonitoringController;
use App\Http\Controllers\Risk\AssessmentController;
use App\Http\Controllers\Risk\MonitoringController;
use App\Http\Controllers\Risk\TopRiskController;
use App\Http\Controllers\Risk\WorksheetController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login', 'as' => 'auth.'], function () {
    Route::get('', fn() => view('auth.index'))->name('login');
    Route::post('', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::delete('', [AuthController::class, 'unauthenticate'])->name('unauthenticate');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('', [AuthController::class, 'change_role'])->name('change-role');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('dashboard/worksheet-by-inherent-risk-scale/{riskScale}', [DashboardController::class, 'worksheet_by_inherent_risk_scale'])
        ->name('dashboard.worksheet_by_inherent_risk_scale');

    Route::get('profile/unit_head', [AuthController::class, 'get_unit_head'])->name('profile.get_unit_head');
    Route::get('profile/risk_metric', [AuthController::class, 'get_risk_metric'])->name('profile.get_risk_metric');

    Route::group(['as' => 'risk.', 'prefix' => 'risk-process'], function () {
        Route::group(['as' => 'worksheet.', 'prefix' => 'worksheet'], function () {
            Route::get('', [WorksheetController::class, 'index'])->name('index');
            Route::get('get-by-inherent-risk-scale/{inherentScale}', [WorksheetController::class, 'get_by_inherent_risk_scale'])->name('get_by_inherent_risk_scale');
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
            Route::get('edit/{monitoringId}', [MonitoringController::class, 'edit_monitoring'])->name('edit_monitoring');
            Route::put('edit/{monitoringId}', [MonitoringController::class, 'update_monitoring'])->name('update_monitoring');
            Route::put('status/{monitoringId}', [MonitoringController::class, 'update_status_monitoring'])->name('update_status_monitoring');
        });

        Route::group(['as' => 'top_risk.', 'prefix' => 'top-risk'], function () {
            Route::get('', [TopRiskController::class, 'index'])->name('index');
            Route::post('', [TopRiskController::class, 'store'])->name('store');
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
    });

    Route::group(['as' => 'master.', 'prefix' => 'master'], function () {
        Route::resource(
            'bumn-scale',
            BUMNScaleController::class,
            [
                'names' => custom_route_names('bumn-scale'),
                'parameters' => ['bumn-scale' => 'bumn-scale']
            ]
        );
        Route::resource(
            'existing-control-type',
            ExistingControlTypeController::class,
            [
                'names' => custom_route_names('existing-control-type'),
                'parameters' => ['existing-control-type' => 'existing-control-type']
            ]
        );
        Route::resource(
            'heatmap',
            HeatmapController::class,
            [
                'names' => custom_route_names('heatmap'),
                'parameters' => ['heatmap' => 'heatmap']
            ]
        );
        Route::resource(
            'kbumn-risk-category',
            KBUMNRiskCategoryController::class,
            [
                'names' => custom_route_names('kbumn-risk-category'),
                'parameters' => ['kbumn-risk-category' => 'kbumn-risk-category']
            ]
        );

        Route::resource(
            'kri-unit',
            KRIUnitController::class,
            [
                'names' => custom_route_names('kri-unit'),
                'parameters' => ['kri-unit' => 'kri-unit']
            ]
        );
        Route::resource(
            'pic',
            PICController::class,
            [
                'names' => custom_route_names('pic'),
                'parameters' => ['pic' => 'pic']
            ]
        );
    });

    Route::group(['as' => 'rbac.', 'prefix' => 'akses'], function () {
        Route::resource(
            'pengguna',
            App\Http\Controllers\RBAC\UserController::class,
            [
                'names' => custom_route_names('user'),
                'parameters' => ['user' => 'user']
            ]
        );
    });
});
