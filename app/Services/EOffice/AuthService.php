<?php

namespace App\Services\EOffice;


class AuthService extends EOfficeAbstract
{
    public function __construct(?string $host, ?string $token)
    {
        parent::__construct($host, $token, 5);
    }

    public function login(array $payload = ['username' => '', 'password' => '']): ?object
    {
        $data = $this->make_request('login_user', $payload, true);

        if (empty($data)) {
            return (object) [];
        }

        $item = [];
        foreach ($data as $key => $value) {
            $item[strtolower($key)] = $value;
        }

        return (object) $item;
    }
}
