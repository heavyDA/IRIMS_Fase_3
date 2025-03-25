<?php

namespace App\DTO\Worksheet;

use App\DTO\DTOContracts;
use App\DTO\Worksheet\Collections\IncidentRequestCollection;
use App\DTO\Worksheet\Collections\MitigationRequestCollection;
use App\DTO\Worksheet\Collections\StrategyRequestCollection;

final class WorksheetRequestDTO implements DTOContracts
{
    public function __construct(
        public ContextRequestDTO $context,
        public StrategyRequestCollection $strategies,
        public IdentificationRequestDTO $identification,
        public IncidentRequestCollection $incidents,
        public MitigationRequestCollection $mitigations,
    ) {
        // Optional runtime type checking
        foreach ($this->strategies as $strategy) {
            if (!$strategy instanceof StrategyRequestDTO) {
                throw new \InvalidArgumentException('Each strategy must be an instance of StrategyRequestDTO');
            }
        }

        foreach ($this->mitigations as $mitigation) {
            if (!$mitigation instanceof MitigationRequestDTO) {
                throw new \InvalidArgumentException('Each mitigation must be an instance of MitigationRequestDTO');
            }
        }
    }

    /**
     * Create a new DTO from an array of data.
     */
    public static function fromArray(array $data): self
    {
        // Transform strategies array to array of StrategyRequestDTO objects
        $strategies = array_map(
            fn(array $strategy) => new StrategyRequestDTO(
                worksheet_id: $data['id'] ?? null,
                id: $strategy['id'] ?? null,
                body: $strategy['body'] ?? '',
                expected_feedback: $strategy['expected_feedback'] ?? '',
                risk_value: $strategy['risk_value'] ?? '',
                risk_value_limit: $strategy['risk_value_limit'] ?? '',
                decision: $strategy['decision'] ?? '',
            ),
            $data['strategies'] ?? []
        );

        // Transform incidents array to array of IncidentRequestDTO objects
        $incidents = array_map(
            fn(array $incident) => new IncidentRequestDTO(
                worksheet_id: $incident['worksheet_id'] ?? null,
                id: $incident['id'] ?? null,
                risk_cause_number: $incident['risk_cause_number'] ?? '',
                risk_cause_code: $incident['risk_cause_code'] ?? '',
                risk_cause_body: $incident['risk_cause_body'] ?? '',
                kri_body: $incident['kri_body'] ?? '',
                kri_unit_id: $incident['kri_unit_id'] ?? null,
                kri_threshold_safe: $incident['kri_threshold_safe'] ?? '',
                kri_threshold_caution: $incident['kri_threshold_caution'] ?? '',
                kri_threshold_danger: $incident['kri_threshold_danger'] ?? '',
            ),
            $data['incidents'] ?? []
        );

        // Transform mitigations array to array of MitigationRequestDTO objects
        $mitigations = array_map(
            fn(array $mitigation) => new MitigationRequestDTO(
                worksheet_incident_id: $mitigation['worksheet_incident_id'] ?? null,
                id: $mitigation['id'] ?? null,
                risk_cause_number: $mitigation['risk_cause_number'] ?? 'null',
                risk_treatment_option_id: $mitigation['risk_treatment_option_id'] ?? null,
                risk_treatment_type_id: $mitigation['risk_treatment_type_id'] ?? null,
                mitigation_plan: $mitigation['mitigation_plan'] ?? '',
                mitigation_output: $mitigation['mitigation_output'] ?? '',
                mitigation_start_date: $mitigation['mitigation_start_date'] ?? '',
                mitigation_end_date: $mitigation['mitigation_end_date'] ?? '',
                mitigation_cost: $mitigation['mitigation_cost'] ?? null,
                mitigation_rkap_program_type_id: $mitigation['mitigation_rkap_program_type_id'] ?? null,
                mitigation_pic: $mitigation['mitigation_pic'] ?? '',
                organization_code: $mitigation['organization_code'] ?? '',
                organization_name: $mitigation['organization_name'] ?? '',
                unit_code: $mitigation['unit_code'] ?? '',
                unit_name: $mitigation['unit_name'] ?? '',
                sub_unit_code: $mitigation['sub_unit_code'] ?? '',
                sub_unit_name: $mitigation['sub_unit_name'] ?? '',
                personnel_area_code: $mitigation['personnel_area_code'] ?? '',
                personnel_area_name: $mitigation['personnel_area_name'] ?? '',
                position_name: $mitigation['position_name'] ?? '',
            ),
            $data['mitigations'] ?? []
        );

        return new self(
            context: ContextRequestDTO::fromArray($data['context'] ?? []),
            identification: IdentificationRequestDTO::fromArray($data['identification'] ?? []),
            incidents: new IncidentRequestCollection($incidents),
            strategies: new StrategyRequestCollection($strategies),
            mitigations: new MitigationRequestCollection($mitigations),
        );
    }

    public function toArray(): array
    {
        return [
            'context' => $this->context->toArray(),
            'identification' => $this->identification->toArray(),
            'incidents' => $this->incidents->toArray(),
            'strategies' => $this->strategies->toArray(),
            'mitigations' => $this->mitigations->toArray(),
        ];
    }
}
