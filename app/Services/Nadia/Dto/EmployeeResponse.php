<?php

namespace App\Services\Nadia\Dto;

use App\DTO\DTOContracts;

class EmployeeResponse implements DTOContracts
{
    public ?string $username;
    public ?string $employee_name;
    public ?string $employee_id;
    public ?string $organization_code;
    public ?string $organization_name;
    public ?string $email;
    public ?string $personnel_area_name;
    public ?string $personnel_area_code;
    public ?string $position_name;
    public ?string $unit_name;
    public ?string $sub_unit_name;
    public ?string $unit_code;
    public ?string $sub_unit_code;
    public ?string $employee_grade_code;
    public ?string $employee_grade;
    public ?string $image_url;

    public function __construct(
        ?string $username,
        ?string $employee_name,
        ?string $employee_id,
        ?string $organization_code,
        ?string $organization_name,
        ?string $email,
        ?string $personnel_area_name,
        ?string $personnel_area_code,
        ?string $position_name,
        ?string $unit_name,
        ?string $sub_unit_name,
        ?string $unit_code,
        ?string $sub_unit_code,
        ?string $employee_grade_code,
        ?string $employee_grade,
        ?string $image_url,
    ) {
        $this->username = $username;
        $this->employee_name = $employee_name;
        $this->employee_id = $employee_id;
        $this->organization_code = $organization_code;
        $this->organization_name = $organization_name;
        $this->email = $email;
        $this->personnel_area_name = $personnel_area_name;
        $this->personnel_area_code = $personnel_area_code;
        $this->position_name = $position_name;
        $this->unit_name = $unit_name;
        $this->sub_unit_name = $sub_unit_name;
        $this->unit_code = $unit_code;
        $this->sub_unit_code = $sub_unit_code;
        $this->employee_grade_code = $employee_grade_code;
        $this->employee_grade = $employee_grade;
        $this->image_url = $image_url;
    }

    public static function fromArray($response): self
    {
        return new self(
            $response['USERNAME'] ?? '',
            $response['EMPLOYEE_NAME'] ?? '',
            $response['EMPLOYEE_ID'] ?? '',
            $response['ORGANIZATION_CODE'] ?? '',
            $response['ORGANIZATION_NAME'] ?? '',
            $response['EMAIL'] ?? '',
            $response['PERSONNEL_AREA_NAME'] ?? '',
            $response['PERSONNEL_AREA_CODE'] ?? '',
            $response['POSITION_NAME'] ?? '',
            $response['UNIT_NAME'] ?? '',
            $response['SUB_UNIT_NAME'] ?? '',
            $response['UNIT_CODE'] ?? '',
            $response['SUB_UNIT_CODE'] ?? '',
            $response['EMPLOYEE_GRADE_CODE'] ?? '',
            $response['EMPLOYEE_GRADE'] ?? '',
            $response['IMAGE_URL'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'employee_name' => $this->employee_name,
            'employee_id' => $this->employee_id,
            'organization_code' => $this->organization_code,
            'organization_name' => $this->organization_name,
            'email' => $this->email,
            'personnel_area_name' => $this->personnel_area_name,
            'personnel_area_code' => $this->personnel_area_code,
            'position_name' => $this->position_name,
            'unit_name' => $this->unit_name,
            'sub_unit_name' => $this->sub_unit_name,
            'unit_code' => $this->unit_code,
            'sub_unit_code' => $this->sub_unit_code,
            'employee_grade_code' => $this->employee_grade_code,
            'employee_grade' => $this->employee_grade,
            'image_url' => $this->image_url
        ];
    }
}
