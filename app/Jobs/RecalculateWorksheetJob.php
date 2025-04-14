<?php

namespace App\Jobs;

use App\Models\Master\Position;
use App\Models\Master\RiskMetric;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetStrategy;
use App\Services\Worksheet\WorksheetCalculateRiskService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class RecalculateWorksheetJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public RiskMetric $riskMetric)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $worksheets = Worksheet::assessmentQuery()
            ->withExpression(
                'position_hierarchy',
                Position::hierarchyQuery(
                    $this->riskMetric->organization_code,
                    false
                )
            )
            ->join('position_hierarchy as ph', 'ph.sub_unit_code', 'w.sub_unit_code')
            ->whereYear('w.created_at', $this->riskMetric->year)
            ->groupBy('w.id')
            ->get();

        try {
            DB::beginTransaction();

            $countUpdated = 0;
            foreach ($worksheets as $worksheet) {
                WorksheetStrategy::where('worksheet_id', $worksheet->worksheet_id)
                    ->update(['risk_value_limit' => $this->riskMetric->limit]);

                if ($worksheet->risk_impact_category == 'kualitatif') {
                    WorksheetIdentification::where('worksheet_id', $worksheet->worksheet_id)
                        ->update($this->recalculateKualitatif($worksheet));
                }

                $countUpdated += 1;
            }
            DB::commit();
            logger()->info("[Risk Metric Job] Successfully recalculate worksheets for [{$this->riskMetric->organization_code}] {$this->riskMetric->organization_name}", ['count' => $worksheets->count(), 'updated' => $countUpdated, 'data' => $worksheets->pluck('worksheet_id')]);
        } catch (Exception $e) {
            DB::rollBack();
            logger()->error("[Risk Metric Job] Failed to recalculate worksheets for [{$this->riskMetric->organization_code}] {$this->riskMetric->organization_name}", ['error' => $e, 'data' => $worksheets->pluck('worksheet_id')]);
        }
    }

    protected function recalculateKualitatif($worksheet): array
    {
        $service = new WorksheetCalculateRiskService(
            'kualitatif',
            $worksheet->inherent_impact_scale,
            $worksheet->inherent_impact_probability,
            $this->riskMetric->limit
        );

        $inherent = $service->calculate()->get();
        $data = [
            'inherent_risk_exposure' => $inherent['exposure'],
            'inherent_risk_level' => $inherent['probability_scale']->risk_level,
            'inherent_risk_scale' => $inherent['probability_scale']->risk_scale,
        ];

        $previousResidual = null;
        foreach ([1, 2, 3, 4] as $quarter) {
            $residualScale = "residual_{$quarter}_impact_scale";
            $residualProbability = "residual_{$quarter}_impact_probability";
            $service = new WorksheetCalculateRiskService(
                'kualitatif',
                $worksheet->{$residualScale},
                $worksheet->{$residualProbability},
                $this->riskMetric->limit
            );

            if ($quarter == 1) {
                $previousResidual = $service->calculate()->get();

                $data = array_merge(
                    $data,
                    [
                        "residual_{$quarter}_risk_exposure" => $previousResidual['exposure'],
                        "residual_{$quarter}_risk_level" => $previousResidual['probability_scale']->risk_level,
                        "residual_{$quarter}_risk_scale" => $previousResidual['probability_scale']->risk_scale,
                    ]
                );
            } else {
                $residual = $service->calculate(previousRiskScale: $previousResidual['scale'])->get();

                $data = array_merge(
                    $data,
                    [
                        "residual_{$quarter}_risk_exposure" => $residual['exposure'],
                        "residual_{$quarter}_risk_level" => $residual['probability_scale']->risk_level,
                        "residual_{$quarter}_risk_scale" => $residual['probability_scale']->risk_scale,
                    ]
                );
            }
        }

        return $data;
    }
}
