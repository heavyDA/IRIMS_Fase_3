<?php

use App\Jobs\PositionJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job('App\Jobs\PositionJob')->everyFifteenSeconds();

Artisan::command('fetch:position', function () {
    PositionJob::dispatch();
})->purpose('Fetch position from API');
