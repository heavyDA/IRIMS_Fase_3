<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::group(['prefix' => 'login', 'as' => 'auth.'], function() {
    Route::get('', fn() => view('auth.index'))->name('login');
    Route::post('', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::delete('', [AuthController::class, 'unauthenticate'])->name('unauthenticate');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
});