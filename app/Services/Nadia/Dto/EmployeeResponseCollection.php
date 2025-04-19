<?php

namespace App\Services\Nadia\Dto;

use Illuminate\Support\Collection;

class EmployeeResponseCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof EmployeeResponse) {
            throw new \InvalidArgumentException('Value must be an instance of EmployeeResponse');
        }

        parent::offsetSet($key, $value);
    }
}
