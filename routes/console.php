<?php

use App\Jobs\FetchEmployeeJob;
use App\Jobs\HTMLCheckerJob;
use App\Jobs\OfficialJob;
use App\Jobs\PositionJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    Bus::chain([
        new PositionJob,
        new OfficialJob,
        new FetchEmployeeJob,
    ])->dispatch();
})
    ->dailyAt('18:00');

Artisan::command('fetch:official', function () {
    OfficialJob::dispatch();
})->purpose('Fetch position from API');

Artisan::command('fetch:position', function () {
    PositionJob::dispatch();
})->purpose('Fetch position from API');

Artisan::command('fetch:employee', function () {
    FetchEmployeeJob::dispatch();
})->purpose('Fetch employee from API');

Artisan::command('html:checker', function () {
    HTMLCheckerJob::dispatch();
})->purpose('Check HTML content');
