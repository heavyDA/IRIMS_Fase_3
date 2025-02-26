<?php

namespace App\Jobs;

use App\Models\Master\Official;
use App\Services\EOffice\OfficialService;
use Exception;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class OfficialJob
{
    use Queueable;

    protected OfficialService $officialService;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->officialService = new OfficialService(env('EOFFICE_URL'), env('EOFFICE_TOKEN'));
    }

    public function handle(): void
    {
        try {
            $officials = $this->officialService->get_all();
            $created = 0;
            $updated = 0;

            if ($officials->isEmpty()) {
                throw new Exception('No data fetched');
            }

            foreach ($officials as $official) {
                $official = Official::updateOrCreate(
                    [
                        'employee_id' => $official->employee_id,
                        'sub_unit_code' => $official->sub_unit_code
                    ],
                    (array) $official
                );

                if ($official->wasRecentlyCreated) {
                    $created += 1;
                } else if ($official) {
                    $updated += 1;
                }
            }

            logger()->info("[Official Job] successfully fetched data number of created {$created} and updated {$updated}");
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error('[Official Job] ' . $e->getMessage());
        }
    }
}
