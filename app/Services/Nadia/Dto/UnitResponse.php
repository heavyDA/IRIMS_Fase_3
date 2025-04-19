<?php

namespace App\Services\Nadia\Dto;

use App\DTO\DTOContracts;

class UnitResponse implements DTOContracts
{
    public ?string $unit_id;
    public ?string $unit_name;
    public ?string $position_name;
    public ?string $unit_code_doc;
    public ?string $supervision_unit_id;
    public ?string $supervision_unit_name;
    public ?string $supervision_position_name;
    public ?string $supervision_unit_code_doc;
    public ?string $regional_category;
    public ?string $branch_code;

    public function __construct(
        ?string $unit_id,
        ?string $unit_name,
        ?string $position_name,
        ?string $unit_code_doc,
        ?string $supervision_unit_id,
        ?string $supervision_unit_name,
        ?string $supervision_position_name,
        ?string $supervision_unit_code_doc,
        ?string $regional_category,
        ?string $branch_code
    ) {
        $this->unit_id = $unit_id;
        $this->unit_name = $unit_name;
        $this->position_name = $position_name;
        $this->unit_code_doc = $unit_code_doc;
        $this->supervision_unit_id = $supervision_unit_id;
        $this->supervision_unit_name = $supervision_unit_name;
        $this->supervision_position_name = $supervision_position_name;
        $this->supervision_unit_code_doc = $supervision_unit_code_doc;
        $this->regional_category = $regional_category;
        $this->branch_code = $branch_code;
    }

    public static function fromArray(array $response): self
    {
        return new self(
            $response['unit_id'] ?? '',
            $response['unit_name'] ?? '',
            $response['position_name'] ?? '',
            $response['unit_code_doc'] ?? '',
            $response['supervision_unit_id'] ?? '',
            $response['supervision_unit_name'] ?? '',
            $response['supervision_position_name'] ?? '',
            $response['supervision_unit_code_doc'] ?? '',
            $response['regional_category'] ?? '',
            $response['branch_code'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'unit_id' => $this->unit_id,
            'unit_name' => $this->unit_name,
            'position_name' => $this->position_name,
            'unit_code_doc' => $this->unit_code_doc,
            'supervision_unit_id' => $this->supervision_unit_id,
            'supervision_unit_name' => $this->supervision_unit_name,
            'supervision_position_name' => $this->supervision_position_name,
            'supervision_unit_code_doc' => $this->supervision_unit_code_doc,
            'regional_category' => $this->regional_category,
            'branch_code' => $this->branch_code,
        ];
    }

    public function toArrayWithTransformedId(): array
    {
        return [
            'unit_code' => $this->supervision_unit_id,
            'unit_code_doc' => $this->supervision_unit_code_doc,
            'unit_name' => $this->supervision_unit_name,
            'unit_position_name' => $this->supervision_position_name,
            'sub_unit_code' => $this->unit_id,
            'sub_unit_code_doc' => $this->unit_code_doc,
            'sub_unit_name' => $this->unit_name,
            'branch_code' => $this->branch_code,
            'regional_category' => $this->regional_category,
            'position_name' => $this->position_name,
        ];
    }
}
