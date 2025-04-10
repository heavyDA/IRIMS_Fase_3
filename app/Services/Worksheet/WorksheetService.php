<?php

namespace App\Services\Worksheet;

use App\DTO\Worksheet\Collections\IncidentRequestCollection;
use App\DTO\Worksheet\Collections\MitigationRequestCollection;
use App\DTO\Worksheet\Collections\StrategyRequestCollection;
use App\DTO\Worksheet\IdentificationRequestDTO;
use App\DTO\Worksheet\IncidentRequestDTO;
use App\DTO\Worksheet\MitigationRequestDTO;
use App\DTO\Worksheet\StrategyRequestDTO;
use App\DTO\Worksheet\WorksheetRequestDTO;
use App\Models\Master\BUMNScale;
use App\Models\Master\Heatmap;
use App\Models\Master\Position;
use App\Models\Risk\Worksheet;
use App\Models\Risk\WorksheetHistory;
use App\Models\Risk\WorksheetIdentification;
use App\Models\Risk\WorksheetIncident;
use App\Models\Risk\WorksheetMitigation;
use App\Models\Risk\WorksheetStrategy;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WorksheetService
{
    public function create(WorksheetRequestDTO $data): Worksheet
    {
        $worksheet = Worksheet::create(
            ['worksheet_code' => $this->generateCode()] +
                $data->context->toArray()
        );
        $worksheet->identification = $this->createIdentification($worksheet, $data->identification);
        $worksheet->strategies = $this->createStrategies($worksheet, $data->strategies);
        $incidents = $this->createIncidents($worksheet, $data->incidents->unique('risk_cause_number'));

        $units = Position::whereIn('sub_unit_code', $data->mitigations->pluck('sub_unit_code'))->get();
        foreach ($incidents as $incident) {
            $incident->mitigations = $this->createMitigations($incident, $units, $data->mitigations->where('risk_cause_number', $incident->risk_cause_number));
        }

        $worksheet->incidents = $incidents;

        return $worksheet;
    }

    public function update(Worksheet $worksheet, WorksheetRequestDTO $data): Worksheet
    {
        $worksheet->update(array_remove_empty($data->context->toArray()));
        $worksheet->identification = $this->createIdentification($worksheet, $data->identification);
        $worksheet->strategies = $this->updateStrategies($worksheet, $data->strategies);
        $incidents = $this->updateIncidents($worksheet, $data->incidents);

        $units = Position::whereIn('sub_unit_code', $data->mitigations->pluck('sub_unit_code'))->get();
        foreach ($incidents as $incident) {
            $incident->mitigations = $this->updateMitigations($incident, $units, $data->mitigations->where('risk_cause_number', $incident->risk_cause_number));
        }

        $worksheet->incidents = $incidents;

        return $worksheet;
    }

    protected function createIdentification(Worksheet $worksheet, IdentificationRequestDTO $data): WorksheetIdentification
    {
        $scales = BUMNScale::whereIn('id', [
            $data->inherent_impact_scale_id,
            $data->residual_1_impact_scale_id,
            $data->residual_2_impact_scale_id,
            $data->residual_3_impact_scale_id,
            $data->residual_4_impact_scale_id,
        ])->get();

        $heatmaps = Heatmap::whereIn('id', [
            $data->inherent_impact_probability_scale_id,
            $data->residual_1_impact_probability_scale_id,
            $data->residual_2_impact_probability_scale_id,
            $data->residual_3_impact_probability_scale_id,
            $data->residual_4_impact_probability_scale_id,
        ])->get();

        $data->inherent_impact_scale_id = $scales->where('id', $data->inherent_impact_scale_id)->first()->id;
        $data->residual_1_impact_scale_id = $scales->where('id', $data->residual_1_impact_scale_id)->first()->id;
        $data->residual_2_impact_scale_id = $scales->where('id', $data->residual_2_impact_scale_id)->first()->id;
        $data->residual_3_impact_scale_id = $scales->where('id', $data->residual_3_impact_scale_id)->first()->id;
        $data->residual_4_impact_scale_id = $scales->where('id', $data->residual_4_impact_scale_id)->first()->id;

        $inherent = $heatmaps->where('id', $data->inherent_impact_probability_scale_id)->first();
        $data->inherent_impact_probability_scale_id = $inherent->id;
        $data->inherent_risk_scale = $inherent->risk_scale;
        $data->inherent_risk_level = $inherent->risk_level;

        for ($i = 1; $i <= 4; $i++) {
            $residual = $heatmaps->where('id', $data->residual_1_impact_probability_scale_id)->first();
            foreach (
                [
                    'impact_probability_scale_id',
                    'risk_scale',
                    'risk_level',
                ] as $idx => $key
            ) {
                $property = $idx == 0 ? 'id' : $key;

                $key = "residual_{$i}_$key";
                $data->$key = $residual->$property;
            }
        }

        return $worksheet->identification()->updateOrCreate([], array_remove_empty($data->toArray()));
    }

    protected function createStrategies(Worksheet $worksheet, StrategyRequestCollection $data)
    {
        return $worksheet->strategies()->createMany($data->map(fn(StrategyRequestDTO $strategy) => $strategy->toArray())->toArray());
    }

    protected function updateStrategies(Worksheet $worksheet, StrategyRequestCollection $data)
    {
        $existingStrategies = $worksheet->strategies()->where('worksheet_id', $worksheet->id)->get();
        $existingStrategies->each(function (WorksheetStrategy $strategy) use ($data) {
            $requestStrategy = $data->where('id', $strategy->id)->first();

            if ($requestStrategy) {
                $strategy->update(array_remove_empty($requestStrategy->toArray()));
            } else {
                $strategy->delete();
            }
        });

        $latestStrategies = $worksheet->strategies()
            ->createMany(
                $data->filter(fn(StrategyRequestDTO $strategy) => empty($strategy->id))
                    ->map(
                        fn(StrategyRequestDTO $strategy) => $strategy->toArray()
                    )
                    ->toArray()
            );

        return $existingStrategies->merge($latestStrategies)->filter(fn(WorksheetStrategy $strategy) => $strategy->exists);
    }

    protected function createIncidents(Worksheet $worksheet, IncidentRequestCollection $data)
    {
        return $worksheet->incidents()->createMany($data->map(fn(IncidentRequestDTO $incident) => $incident->toArray())->toArray());
    }

    protected function updateIncidents(Worksheet $worksheet, IncidentRequestCollection $data)
    {
        $existingIncidents = $worksheet->incidents()->where('worksheet_id', $worksheet->id)->get();
        $existingIncidents = $existingIncidents->filter(function (WorksheetIncident $incident) use ($data) {
            $requestIncident = $data->where('id', $incident->id)->first();

            if ($requestIncident) {
                $incident->update(array_remove_empty($requestIncident->toArray()));
                return true;
            }

            $incident->delete();
            return false;
        });

        $latestIncidents = $worksheet->incidents()
            ->createMany(
                $data->filter(fn(IncidentRequestDTO $incident) => empty($incident->id))
                    ->map(
                        fn(IncidentRequestDTO $incident) => $incident->toArray()
                    )
                    ->toArray()
            );

        return $existingIncidents->merge($latestIncidents);
    }

    protected function createMitigations(WorksheetIncident $incident, Collection $units, MitigationRequestCollection $data)
    {
        return $incident->mitigations()
            ->createMany(
                $data->map(
                    function (MitigationRequestDTO $mitigation) use ($units) {
                        $unit = $units->where('sub_unit_code', $mitigation->sub_unit_code)->first();

                        return $unit->only(
                            'unit_code',
                            'unit_name',
                            'sub_unit_code',
                            'sub_unit_name',
                            'position_name',
                        ) +
                            [
                                'risk_cause_number' => $mitigation->risk_cause_number,
                                'risk_treatment_option_id' => $mitigation->risk_treatment_option_id,
                                'risk_treatment_type_id' => $mitigation->risk_treatment_type_id,
                                'mitigation_plan' => $mitigation->mitigation_plan,
                                'mitigation_output' => $mitigation->mitigation_output,
                                'mitigation_start_date' => $mitigation->mitigation_start_date,
                                'mitigation_end_date' => $mitigation->mitigation_end_date,
                                'mitigation_cost' => $mitigation->mitigation_cost,
                                'mitigation_rkap_program_type_id' => $mitigation->mitigation_rkap_program_type_id,
                                'organization_code' => $unit->sub_unit_code,
                                'organization_name' => $unit->sub_unit_name,
                                'mitigation_pic' => "[{$unit->sub_unit_code_doc}] {$unit->sub_unit_name}",
                                'personnel_area_code' => $unit->branch_code,
                                'personnel_area_name' => '-',
                            ];
                    }
                )
                    ->toArray()
            );
    }

    protected function updateMitigations(WorksheetIncident $incident, Collection $units, MitigationRequestCollection $data)
    {
        $existingMitigations = $incident->mitigations()->where('worksheet_incident_id', $incident->id)->get();
        $existingMitigations->each(function (WorksheetMitigation $mitigation) use ($data, $units) {
            $requestMitigation = $data->where('id', $mitigation->id)->first();

            if ($requestMitigation) {
                $unit = $units->where('sub_unit_code', $mitigation->sub_unit_code)->first();
                $mitigation->update(
                    $unit->only(
                        'unit_code',
                        'unit_name',
                        'sub_unit_code',
                        'sub_unit_name',
                        'position_name',
                    ) +
                        array_remove_empty($requestMitigation->toArray()) +
                        [
                            'personnel_area_code' => $unit->branch_code,
                            'personnel_area_name' => '-',
                        ]
                );
            } else {
                $mitigation->delete();
            }
        });

        $latestMitigations = $incident->mitigations()
            ->createMany(
                $data->filter(fn(MitigationRequestDTO $mitigation) => empty($mitigation->id))
                    ->map(
                        function (MitigationRequestDTO $mitigation) use ($units) {
                            $unit = $units->where('sub_unit_code', $mitigation->sub_unit_code)->first();
                            return $unit->only(
                                'unit_code',
                                'unit_name',
                                'sub_unit_code',
                                'sub_unit_name',
                                'position_name',
                            ) +
                                [
                                    'risk_cause_number' => $mitigation->risk_cause_number,
                                    'risk_treatment_option_id' => $mitigation->risk_treatment_option_id,
                                    'risk_treatment_type_id' => $mitigation->risk_treatment_type_id,
                                    'mitigation_plan' => $mitigation->mitigation_plan,
                                    'mitigation_output' => $mitigation->mitigation_output,
                                    'mitigation_start_date' => $mitigation->mitigation_start_date,
                                    'mitigation_end_date' => $mitigation->mitigation_end_date,
                                    'mitigation_cost' => $mitigation->mitigation_cost,
                                    'mitigation_rkap_program_type_id' => $mitigation->mitigation_rkap_program_type_id,
                                    'organization_code' => $unit->sub_unit_code,
                                    'organization_name' => $unit->sub_unit_name,
                                    'mitigation_pic' => "[{$unit->sub_unit_code_doc}] {$unit->sub_unit_name}",
                                    'personnel_area_code' => $unit->branch_code,
                                    'personnel_area_name' => '-',
                                ];
                        }
                    )
                    ->toArray()
            );

        return $existingMitigations->merge($latestMitigations);
    }

    public function createHistory(Worksheet $worksheet): WorksheetHistory
    {
        return new WorksheetHistory();
    }

    protected function generateCode()
    {
        return 'WR/' . date('Y') . '/' . Str::random(8);
    }
}
