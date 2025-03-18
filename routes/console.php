<?php

use App\Jobs\FetchEmployeeJob;
use App\Jobs\OfficialJob;
use App\Jobs\PositionJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job('App\Jobs\PositionJob')->everyFifteenSeconds();

Artisan::command('fetch:official', function () {
    OfficialJob::dispatch();
})->purpose('Fetch position from API');

Artisan::command('fetch:position', function () {
    PositionJob::dispatch();
    Artisan::call('db:seed --class=PositionSeeder');
})->purpose('Fetch position from API');

Artisan::command('fetch:employee', function () {
    FetchEmployeeJob::dispatch();
})->purpose('Fetch employee from API');
