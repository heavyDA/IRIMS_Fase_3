<?php

namespace App\DTO\Worksheet;

use App\DTO\DTOContracts;

final class StrategyRequestDTO implements DTOContracts
{
    public function __construct(
        public ?int $worksheet_id = null,
        public ?int $id = null,
        public string $body,
        public string $expected_feedback,
        public string $risk_value,
        public string $risk_value_limit,
        public string $decision,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            worksheet_id: $data['worksheet_id'] ?? null,
            id: $data['id'] ?? null,
            body: $data['body'] ?? '',
            expected_feedback: $data['expected_feedback'] ?? '',
            risk_value: $data['risk_value'] ?? '',
            risk_value_limit: $data['risk_value_limit'] ?? '',
            decision: $data['decision'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'worksheet_id' => $this->worksheet_id,
            'id' => $this->id,
            'body' => $this->body,
            'expected_feedback' => $this->expected_feedback,
            'risk_value' => $this->risk_value,
            'risk_value_limit' => $this->risk_value_limit,
            'decision' => $this->decision,
        ];
    }
}
