<?php

if(!function_exists('app')) {
    function app(): \App\ServiceContainer
    {
        return \App\Application::getServiceContainer();
    }
}

if(!function_exists('env')) {
    function env(string $key, $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}

if(!function_exists('config')) {
    function config(string $key, $default = null): mixed
    {
        return \App\Facades\Config::get($key, $default);
    }
}