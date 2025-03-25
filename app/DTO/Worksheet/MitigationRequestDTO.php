<?php

namespace App\DTO\Worksheet;

use App\DTO\DTOContracts;

final class MitigationRequestDTO implements DTOContracts
{
    public function __construct(
        public ?int $worksheet_incident_id = null,
        public ?int $id = null,
        public string $risk_cause_number,
        public ?int $risk_treatment_option_id = null,
        public ?int $risk_treatment_type_id = null,
        public string $mitigation_plan,
        public string $mitigation_output,
        public string $mitigation_start_date,
        public string $mitigation_end_date,
        public string $mitigation_cost,
        public ?int $mitigation_rkap_program_type_id = null,
        public string $mitigation_pic,
        public string $organization_code,
        public string $organization_name,
        public string $unit_code,
        public string $unit_name,
        public string $sub_unit_code,
        public string $sub_unit_name,
        public string $personnel_area_code,
        public string $personnel_area_name,
        public string $position_name
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            worksheet_incident_id: $data['worksheet_incident_id'] ?? null,
            id: $data['id'] ?? null,
            risk_cause_number: $data['risk_cause_number'] ?? '',
            risk_treatment_option_id: $data['risk_treatment_option_id'] ?? null,
            risk_treatment_type_id: $data['risk_treatment_type_id'] ?? null,
            mitigation_plan: $data['mitigation_plan'] ?? '',
            mitigation_output: $data['mitigation_output'] ?? '',
            mitigation_start_date: $data['mitigation_start_date'] ?? '',
            mitigation_end_date: $data['mitigation_end_date'] ?? '',
            mitigation_cost: $data['mitigation_cost'] ?? '',
            mitigation_rkap_program_type_id: $data['mitigation_rkap_program_type_id'] ?? null,
            mitigation_pic: $data['mitigation_pic'] ?? '',
            organization_code: $data['organization_code'] ?? '',
            organization_name: $data['organization_name'] ?? '',
            unit_code: $data['unit_code'] ?? '',
            unit_name: $data['unit_name'] ?? '',
            sub_unit_code: $data['sub_unit_code'] ?? '',
            sub_unit_name: $data['sub_unit_name'] ?? '',
            personnel_area_code: $data['personnel_area_code'] ?? '',
            personnel_area_name: $data['personnel_area_name'] ?? '',
            position_name: $data['position_name'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'worksheet_incident_id' => $this->worksheet_incident_id,
            'id' => $this->id,
            'risk_cause_number' => $this->risk_cause_number,
            'risk_treatment_option_id' => $this->risk_treatment_option_id,
            'risk_treatment_type_id' => $this->risk_treatment_type_id,
            'mitigation_plan' => $this->mitigation_plan,
            'mitigation_output' => $this->mitigation_output,
            'mitigation_start_date' => $this->mitigation_start_date,
            'mitigation_end_date' => $this->mitigation_end_date,
            'mitigation_cost' => $this->mitigation_cost,
            'mitigation_rkap_program_type_id' => $this->mitigation_rkap_program_type_id,
            'mitigation_pic' => $this->mitigation_pic,
            'organization_code' => $this->organization_code,
            'organization_name' => $this->organization_name,
            'unit_code' => $this->unit_code,
            'unit_name' => $this->unit_name,
            'sub_unit_code' => $this->sub_unit_code,
            'sub_unit_name' => $this->sub_unit_name,
            'personnel_area_code' => $this->personnel_area_code,
            'personnel_area_name' => $this->personnel_area_name,
            'position_name' => $this->position_name
        ];
    }
}
