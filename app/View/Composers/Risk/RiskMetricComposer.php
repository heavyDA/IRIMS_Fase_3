<?php

namespace App\View\Composers\Risk;

use App\Enums\State;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Services\Worksheet\RiskMetricService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\View\View;

class RiskMetricComposer
{
    public function compose(View $view)
    {
        try {
            $unit = null;

            if (request('worksheet')) {
                $worksheet = Worksheet::findByEncryptedId(request('worksheet'));

                if ($worksheet) {
                    $unit = Position::where('sub_unit_code', $worksheet->sub_unit_code)->first();
                }
            }

            if (!$unit) {
                $unit = position_helper()->getUnitLocation();
            }

            $risk_metric = RiskMetricService::get($unit);
            $view->with('risk_metric', $risk_metric);
        } catch (Exception $e) {
            logger()->error('[RiskMetricComposer] Nilai Limit Risiko tidak ditemukan untuk unit ' . $unit->sub_unit_code . ', User ID ' . auth()->user()->employee_id);
            flash_message('flash_message', 'Nilai Limit Risiko tidak ditemukan', State::ERROR);

            throw new HttpResponseException(redirect()->route('dashboard.index'));
        }
    }
}
