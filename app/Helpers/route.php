<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('custom_route_names')) {
    function custom_route_names(string $routeName = ''): array
    {
        if (!$routeName) {
            return [];
        }

        return [
            'index' => __('route.index', ['attribute' => $routeName]),
            'show' => __('route.show', ['attribute' => $routeName]),
            'create' => __('route.create', ['attribute' => $routeName]),
            'store' => __('route.store', ['attribute' => $routeName]),
            'edit' => __('route.edit', ['attribute' => $routeName]),
            'update' => __('route.update', ['attribute' => $routeName]),
            'destroy' => __('route.destroy', ['attribute' => $routeName]),
        ];
    }
}

if (!function_exists('get_current_route_name')) {
    /**
     * @param bool $removeAction default false
     */
    function get_current_route_name(bool $removeAction = false): string
    {
        $routeName = Route::getCurrentRoute()->getName();

        if ($removeAction) {
            $routeName = remove_route_action($routeName ?? '');
        }

        return $routeName;
    }
}

if (!function_exists('check_current_route_name')) {
    function check_current_route_name(string $routeTarget, string $currentRoute): bool
    {
        return $routeTarget !== "" && $routeTarget === $currentRoute;
    }
}

if (!function_exists('remove_route_action')) {
    function remove_route_action(string $routeName): string
    {
        $routeNameSplit = explode('.', $routeName);

        if (count($routeNameSplit) > 1)
            array_pop($routeNameSplit);

        $routeName = implode('.', $routeNameSplit);

        return $routeName;
    }
}

if (!function_exists('get_route_action')) {
    function get_route_action(string $routeName): string
    {
        $routeNameSplit = explode('.', $routeName);
        return end($routeNameSplit);
    }
}
