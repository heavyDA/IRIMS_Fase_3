<?php

namespace App\Services\Nadia;

use App\Services\Nadia\Dto\RoleResponse;
use App\Services\Nadia\Dto\RoleResponseCollection;
use App\Services\Nadia\Dto\UnitResponse;
use App\Services\Nadia\Dto\UnitResponseCollection;

class UnitService extends NadiaAbstract
{
    public function unit_get_all(): UnitResponseCollection
    {
        $response = $this->make_request('all_unit', [], true, [
            'Authorization' => $this->getToken()
        ]);

        return new UnitResponseCollection(array_map(
            fn(array $unit) => UnitResponse::fromArray($unit),
            $response->toArray()['data']
        ));
    }

    public function role_get_all(): RoleResponseCollection
    {
        $response = $this->make_request('roles_get', [], true, [
            'Authorization' => $this->getToken()
        ]);

        return new RoleResponseCollection(array_map(
            fn(array $role) => RoleResponse::fromArray($role),
            $response->toArray()['data']
        ));
    }
}
