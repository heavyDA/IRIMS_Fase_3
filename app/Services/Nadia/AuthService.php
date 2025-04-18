<?php

namespace App\Services\Nadia;

use App\Services\Nadia\Dto\LoginSystemResponse;
use App\Services\Nadia\Dto\EmployeeResponse;
use App\Services\Nadia\NadiaException;

class AuthService extends NadiaAbstract
{
    public function login_system(): self
    {
        $response = $this->make_request('login_system', [
            'application_id' => $this->getAppId(),
            'secret_key' => $this->getAppKey()
        ]);

        $data = LoginSystemResponse::fromArray($response->toArray()['data']);
        logger()->info('[' . self::SERVICE_NAME . '] Login System: ' . $response->message);
        if (!$data->token) {
            throw new NadiaException('Failed to login into system');
        }

        $this->setToken('Bearer ' . $data->token);
        return $this;
    }

    public function login_user(array $payload = ['username' => '', 'password' => '']): EmployeeResponse
    {
        $response = $this->make_request('login_user', $payload, true, [
            'Authorization' => $this->getToken()
        ]);

        logger()->info('[' . self::SERVICE_NAME . '] Login User: ' . $response->message, ['payload' => ['username' => $payload['username']]]);

        return EmployeeResponse::fromArray($response->toArray()['data'][0]);
    }
}
