<?php

use App\Enums\State;

if (!function_exists('flash_message')) {
    /**
     * @param string $message
     * @param string $type
     *
     * @return void
     */
    function flash_message(string $name = 'flash_message', string $message = '', State $type = State::SUCCESS): void
    {
        session()->flash($name, ['message' => $message, 'type' => $type]);
    }
}