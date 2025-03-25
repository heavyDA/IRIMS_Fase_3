<?php

namespace App\DTO\Worksheet;

use App\DTO\DTOContracts;

final class ContextRequestDTO implements DTOContracts
{
    public function __construct(
        public ?int $id = null,
        public ?string $worksheet_code = '',
        public string $worksheet_number,
        public string $unit_code,
        public string $unit_name,
        public string $sub_unit_code,
        public string $sub_unit_name,
        public string $organization_code,
        public string $organization_name,
        public string $personnel_area_code,
        public string $personnel_area_name,
        public string $company_code,
        public string $company_name,
        public string $target_body,
        public string $status,
        public string $status_monitoring,
        public string $created_by,
        public string $risk_number,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            worksheet_code: $data['worksheet_code'] ?? '',
            worksheet_number: $data['worksheet_number'] ?? '',
            unit_code: $data['unit_code'] ?? '',
            unit_name: $data['unit_name'] ?? '',
            sub_unit_code: $data['sub_unit_code'] ?? '',
            sub_unit_name: $data['sub_unit_name'] ?? '',
            organization_code: $data['organization_code'] ?? '',
            organization_name: $data['organization_name'] ?? '',
            personnel_area_code: $data['personnel_area_code'] ?? '',
            personnel_area_name: $data['personnel_area_name'] ?? '',
            company_code: $data['company_code'] ?? '',
            company_name: $data['company_name'] ?? '',
            target_body: $data['target_body'] ?? '',
            status: $data['status'] ?? '',
            status_monitoring: $data['status_monitoring'] ?? '',
            created_by: $data['created_by'] ?? '',
            risk_number: $data['risk_number'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'worksheet_code' => $this->worksheet_code,
            'unit_code' => $this->unit_code,
            'unit_name' => $this->unit_name,
            'sub_unit_code' => $this->sub_unit_code,
            'sub_unit_name' => $this->sub_unit_name,
            'organization_code' => $this->organization_code,
            'organization_name' => $this->organization_name,
            'personnel_area_code' => $this->personnel_area_code,
            'personnel_area_name' => $this->personnel_area_name,
            'company_code' => $this->company_code,
            'company_name' => $this->company_name,
            'target_body' => $this->target_body,
            'status' => $this->status,
            'status_monitoring' => $this->status_monitoring,
            'created_by' => $this->created_by,
            'risk_number' => $this->risk_number,
        ];
    }
}
