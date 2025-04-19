<?php

namespace App\Services\Nadia;

use App\Services\Nadia\Dto\EmployeeResponse;
use App\Services\Nadia\Dto\EmployeeResponseCollection;

class EmployeeService extends NadiaAbstract
{
    public function official_get_all(?string $date = '', ?string $unitCode = ''): EmployeeResponseCollection
    {
        $payload = [
            'effective_date' => $date ?: now()->format('Y-m-d')
        ];

        if ($unitCode) {
            $payload['organization_code'] = $unitCode;
        }

        $response = $this->make_request('pejabat_get', $payload, true, [
            'Authorization' => $this->getToken()
        ]);

        return new EmployeeResponseCollection(array_map(
            fn(array $official) => EmployeeResponse::fromArray($official),
            $response->toArray()['data']
        ));
    }

    public function staff_get_all(?string $date = '', ?string $unitCode = ''): EmployeeResponseCollection
    {
        $payload = [
            'effective_date' => $date ?: now()->format('Y-m-d')
        ];

        if ($unitCode) {
            $payload['organization_code'] = $unitCode;
        }

        $response = $this->make_request('sekretaris_get', $payload, true, [
            'Authorization' => $this->getToken()
        ]);

        return new EmployeeResponseCollection(array_map(
            fn(array $staff) => EmployeeResponse::fromArray($staff),
            $response->toArray()['data']
        ));
    }
}
