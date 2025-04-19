<?php

namespace App\Services\Nadia\Dto;

use App\DTO\DTOContracts;

class LoginSystemResponse implements DTOContracts
{
    public ?string $token;

    public function __construct(?string $token = '')
    {
        $this->token = $token;
    }

    public static function fromArray($response): self
    {
        return new self($response['token'] ?? '');
    }

    public function toArray(): array
    {
        return ['token' => $this->token];
    }
}
