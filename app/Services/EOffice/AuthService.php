<?php

namespace App\Services\EOffice;


class AuthService extends EOfficeAbstract
{
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
