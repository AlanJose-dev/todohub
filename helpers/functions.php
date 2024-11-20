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

if(!function_exists('storage_path')) {
    function storage_path(string $path): string
    {
        return BASE_PATH . 'storage/' . $path;
    }
}

if(!function_exists('component')) {
    function component(string $path): mixed
    {
        $file = BASE_PATH . "resources/components/$path.view.php";
        if(!file_exists($file)) {
            throw new \Exception("Component '$path' not found");
        }
        return require $file;
    }
}

if(!function_exists('dd')) {
    function dd(mixed $data): void
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }
}