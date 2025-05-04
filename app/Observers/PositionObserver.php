<?php

namespace App\Observers;

use App\Models\Master\Position;
use App\Models\UserUnit;
use Illuminate\Support\Facades\DB;

class PositionObserver
{
    public function deleting(Position $position)
    {
        logger()->info('[Position] Deleting position, trying to remove related user unit.', $position->toArray());

        try {
            $userUnits = UserUnit::where('sub_unit_code', $position->sub_unit_code)
                ->where('position_name', $position->position_name)
                ->get();

            foreach ($userUnits as $userUnit) {
                DB::table('sessions')->where('user_id', $userUnit->user_id)->delete();
                $userUnit->delete();
            }

            logger()->info("[Position] User unit deleted successfully.", $position->toArray());
            return true;
        } catch (\Exception $e) {
            logger()->error('[Position] Failed to remove related user unit.', $position->toArray() + ['message' => $e->getMessage()]);
            return false;
        }
    }
}
