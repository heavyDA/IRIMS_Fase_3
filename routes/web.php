<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Master\{
    BUMNScaleController,
    ExistingControlTypeController,
    HeatmapController,
    KBUMNRiskCategoryController,
    KRIUnitController,
    PICController
};
use App\Http\Controllers\Risk\AssessmentController;
use App\Jobs\PositionJob;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    PositionJob::dispatch();
});

Route::group(['prefix' => 'login', 'as' => 'auth.'], function () {
    Route::get('', fn() => view('auth.index'))->name('login');
    Route::post('', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::delete('', [AuthController::class, 'unauthenticate'])->name('unauthenticate');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('', [AuthController::class, 'change_role'])->name('change-role');
    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');

    Route::get('profile/unit_head', [AuthController::class, 'get_unit_head'])->name('profile.get_unit_head');
    Route::get('profile/risk_metric', [AuthController::class, 'get_risk_metric'])->name('profile.get_risk_metric');

    Route::group(['as' => 'risk.', 'prefix' => 'risk'], function () {
        Route::group(['as' => 'assessment.worksheet.', 'prefix' => 'assessment/worksheet'], function () {
            Route::get('', [App\Http\Controllers\Risk\AssessmentWorksheetController::class, 'index'])->name('index');
            Route::post('', [App\Http\Controllers\Risk\AssessmentWorksheetController::class, 'store'])->name('store');


            Route::get('{worksheet}', [App\Http\Controllers\Risk\AssessmentWorksheetController::class, 'show'])->name('show');
            Route::get('{worksheet}/edit', [App\Http\Controllers\Risk\AssessmentWorksheetController::class, 'edit'])->name('edit');
            Route::put('{worksheet}/edit', [App\Http\Controllers\Risk\AssessmentWorksheetController::class, 'update'])->name('update');
            Route::put('{worksheet}/status', [App\Http\Controllers\Risk\AssessmentWorksheetController::class, 'update_status'])->name('update-status');
        });

        Route::group(['as' => 'process.monitoring.', 'prefix' => 'process/monitoring'], function () {
            Route::get('', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'index'])->name('index');
            Route::get('{worksheet}', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'show'])->name('show');
            Route::get('{worksheet}/create', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'create'])->name('create');
            Route::post('{worksheet}/create', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'store'])->name('store');
            Route::get('detail/{monitoringId}', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'show_monitoring'])->name('show_monitoring');
            Route::get('edit/{monitoringId}', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'edit_monitoring'])->name('edit_monitoring');
            Route::put('edit/{monitoringId}', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'update_monitoring'])->name('update_monitoring');
            Route::put('status/{monitoringId}', [App\Http\Controllers\Risk\ProcessMonitoringController::class, 'update_status_monitoring'])->name('update_status_monitoring');
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
