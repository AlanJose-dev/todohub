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
        return \App\Facades\Support\Config::get($key, $default);
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
    function dd(mixed $value, mixed ...$values): void
    {
        echo "<pre>";
        var_dump($value, ...$values);
        echo "</pre>";
        die();
    }
}

if(!function_exists('session')) {
    function session(): \Symfony\Component\HttpFoundation\Session\Session
    {
        return app()->resolve('_session');
    }
}

if(!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        $key = 'csrf_token';
        $session = session();
        if(!$session->has($key)) {
            $session->set($key, bin2hex(random_bytes(32)));
        }
        return $session->get($key);
    }
}

if(!function_exists('database')) {
    function database(): PDO
    {
        return app()->resolve('_database');
    }
}