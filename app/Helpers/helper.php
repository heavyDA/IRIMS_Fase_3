<?php

use App\Services\PositionService;
use App\Services\RoleService;

if (!function_exists('role')) {
    function role()
    {
        return app(RoleService::class);
    }
}

if (!function_exists('position_helper')) {
    function position_helper()
    {
        return app(PositionService::class);
    }
}

/**
 * Get Current Timezone from user session
 * The timezone is received from user browser
 * If the timezone is not set, it will return 'Asia/Jakarta' as default
 */
if (!function_exists('get_current_timezone')) {
    function get_current_timezone(): string
    {
        $timezones = [
            'Asia/Jakarta',
            'Asia/Jayapura',
            'Asia/Pontianak',
            'Asia/Makassar',
        ];

        $timezone = session()->get('current_timezone');
        return in_array($timezone, $timezones) ? $timezone : 'Asia/Jakarta';
    }
}

if (!function_exists('purify')) {
    function purify(?string $string = ''): string
    {
        return empty($string) ? '' : clean(html_entity_decode($string));
    }
}
