<?php

namespace App\Services\Nadia\Dto;

use Illuminate\Support\Collection;

class UnitResponseCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof UnitResponse) {
            throw new \InvalidArgumentException('Value must be an instance of UnitResponse');
        }

        parent::offsetSet($key, $value);
    }
}
