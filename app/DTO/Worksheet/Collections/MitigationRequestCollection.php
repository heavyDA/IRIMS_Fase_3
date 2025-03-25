<?php

namespace App\DTO\Worksheet\Collections;

use App\DTO\Worksheet\MitigationRequestDTO;
use Illuminate\Support\Collection;

class MitigationRequestCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof MitigationRequestDTO) {
            throw new \InvalidArgumentException('Value must be an instance of MitigationRequestDTO');
        }

        parent::offsetSet($key, $value);
    }
}
