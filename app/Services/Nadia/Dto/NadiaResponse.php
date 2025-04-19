<?php

namespace App\Services\Nadia\Dto;

use App\DTO\DTOContracts;

class NadiaResponse implements DTOContracts
{
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    public ?string $status;
    public ?string $message;
    public ?int $totalData;
    public object|array $data;
    public ?string $token;

    public function __construct(?string $status = '', ?string $message = '', object|array $data = [], ?int $totalData = 0, ?string $token = '')
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->totalData = $totalData;
        $this->token = $token;
    }

    public static function fromArray($response): self
    {
        return new self(
            $response['status'] ?? '',
            $response['message'] ?? '',
            $response['data'] ?? [],
            $response['totalData'] ?? 0,
            $response['token'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'total_data' => $this->totalData,
            'token' => $this->token
        ];
    }
}
