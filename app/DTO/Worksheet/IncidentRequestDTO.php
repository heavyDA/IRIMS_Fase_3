<?php

namespace App\DTO\Worksheet;

use App\DTO\DTOContracts;

final class IncidentRequestDTO implements DTOContracts
{
    public function __construct(
        public ?int $worksheet_id = null,
        public ?int $id = null,
        public string $risk_cause_number,
        public string $risk_cause_code,
        public string $risk_cause_body,
        public string $kri_body,
        public ?int $kri_unit_id = null,
        public string $kri_threshold_safe,
        public string $kri_threshold_caution,
        public string $kri_threshold_danger,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            worksheet_id: $data['worksheet_id'] ?? null,
            id: $data['id'] ?? null,
            risk_cause_number: $data['risk_cause_number'] ?? '',
            risk_cause_code: $data['risk_cause_code'] ?? '',
            risk_cause_body: $data['risk_cause_body'] ?? '',
            kri_body: $data['kri_body'] ?? '',
            kri_unit_id: $data['kri_unit_id'] ?? null,
            kri_threshold_safe: $data['kri_threshold_safe'] ?? '',
            kri_threshold_caution: $data['kri_threshold_caution'] ?? '',
            kri_threshold_danger: $data['kri_threshold_danger'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'worksheet_id' => $this->worksheet_id,
            'id' => $this->id,
            'risk_cause_number' => $this->risk_cause_number,
            'risk_cause_code' => $this->risk_cause_code,
            'risk_cause_body' => $this->risk_cause_body,
            'kri_body' => $this->kri_body,
            'kri_unit_id' => $this->kri_unit_id,
            'kri_threshold_safe' => $this->kri_threshold_safe,
            'kri_threshold_caution' => $this->kri_threshold_caution,
            'kri_threshold_danger' => $this->kri_threshold_danger,
        ];
    }
}
