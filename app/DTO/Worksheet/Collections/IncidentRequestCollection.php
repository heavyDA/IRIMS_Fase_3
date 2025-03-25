<?php

namespace App\DTO\Worksheet\Collections;

use App\DTO\Worksheet\IncidentRequestDTO;
use Illuminate\Support\Collection;

class IncidentRequestCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof IncidentRequestDTO) {
            throw new \InvalidArgumentException('Value must be an instance of IncidentRequestDTO');
        }

        parent::offsetSet($key, $value);
    }
}
