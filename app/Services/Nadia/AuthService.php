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

        $data = $response->toArray()['data'];
        if (empty($data)) {
            logger()->info('[' . self::SERVICE_NAME . '] Login User: ' . $response->message . ', with empty data', ['payload' => ['username' => $payload['username']]]);
            throw new NadiaException('Failed to login user, success with empty data');
        }

        $data = is_associative_array($data) ? $data : reset($data);
        if ($data === false) {
            logger()->info('[' . self::SERVICE_NAME . '] Login User: ' . $response->message . ', with empty data', ['payload' => ['username' => $payload['username'], 'data' => $data]]);
            throw new NadiaException('Failed to login user, success with empty data');
        }

        logger()->info('[' . self::SERVICE_NAME . '] Login User: ' . $response->message, ['data' => $data]);

        return EmployeeResponse::fromArray($data);
    }
}
