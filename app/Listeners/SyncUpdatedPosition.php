<?php

namespace App\Listeners;

use App\Events\PositionUpdated;
use App\Models\Master\Position;
use App\Models\UserUnit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class SyncUpdatedPosition implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

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
    public function handle(PositionUpdated $event): void
    {
        $userUnits = UserUnit::where('sub_unit_code', $event->position->sub_unit_code)
            ->where('position_name', $event->position->position_name)
            ->get();

        $roles = explode(',', $event->position->assigned_roles);
        if (empty($roles)) {
            $roles = ['risk admin'];
        }

        $userUnits
            ->each(function ($userUnit) use ($event, $roles) {
                try {
                    $userUnit->syncRoles($roles);
                    DB::table('sessions')->where('user_id', $userUnit->user_id)->delete();
                } catch (\Exception $e) {
                    logger()->error('[Position] Failed to perform sync roles to user unit.', $userUnit->toArray() + ['message' => $e->getMessage()]);
                }
            });
    }
}
