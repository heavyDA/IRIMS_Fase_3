<?php

namespace App\DTO\Worksheet\Collections;

use App\DTO\Worksheet\StrategyRequestDTO;
use Illuminate\Support\Collection;

class StrategyRequestCollection extends Collection
{
    public function offsetSet($key, $value): void
    {
        if (!$value instanceof StrategyRequestDTO) {
            throw new \InvalidArgumentException('Value must be an instance of StrategyRequestDTO');
        }

        parent::offsetSet($key, $value);
    }
}
