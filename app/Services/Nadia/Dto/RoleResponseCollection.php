<?php

namespace App\Services\Nadia\Dto;

use Illuminate\Support\Collection;

class RoleResponseCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof RoleResponse) {
            throw new \InvalidArgumentException('Value must be an instance of RoleResponse');
        }

        parent::offsetSet($key, $value);
    }
}
