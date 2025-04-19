<?php

namespace App\Services\Nadia\Dto;

use App\DTO\DTOContracts;

class RoleResponse implements DTOContracts
{
    public ?string $personnel_area_code;
    public ?string $unit_code;
    public ?string $unit_name;
    public ?string $position_name;

    public function __construct(?string $personnel_area_code = '', ?string $unit_code = '', ?string $unit_name = '', ?string $position_name = '')
    {
        $this->personnel_area_code = $personnel_area_code;
        $this->unit_code = $unit_code;
        $this->unit_name = $unit_name;
        $this->position_name = $position_name;
    }

    public static function fromArray($response): self
    {
        return new self(
            $response['PERSONNEL_AREA_CODE'] ?? '',
            $response['UNIT_CODE'] ?? '',
            $response['UNIT_NAME'] ?? '',
            $response['POSITION_NAME'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'personnel_area_code' => $this->personnel_area_code,
            'unit_code' => $this->unit_code,
            'unit_name' => $this->unit_name,
            'position_name' => $this->position_name
        ];
    }
}
