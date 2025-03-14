<?php

namespace App\Listeners;

use App\Events\RiskMetricChanged;
use App\Jobs\RecalculateWorksheetJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RecalculateWorksheet
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RiskMetricChanged $event): void
    {
        RecalculateWorksheetJob::dispatch($event->riskMetric);
    }
}
