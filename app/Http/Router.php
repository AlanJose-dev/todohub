<?php

namespace App\Http;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private static RouteCollection $routes;

    private static function addRoute(string $path, array|callable $action, string $method, array $options = []): void
    {
        $defaults = is_array($action) ?
            ['_controller' => $action[0], '_action' => $action[1], '_middlewares' => $options['middlewares'] ?? []] :
            ['_action' => $action, '_middlewares' => $options['middlewares'] ?? []];
        self::$routes->add(
            $options['name'] ?? str_replace('/', '.', $path . $method),
            new Route(
                $path,
                $defaults,
                requirements: $options['requirements'] ?? [],
                methods: [$method],
            )
        );
    }

    public static function init()
    {
        self::$routes = new RouteCollection();
    }

    public static function loadRouteFiles(array $filesPath): void
    {
        foreach ($filesPath as $file) {
            require BASE_PATH . 'routes/' . $file . '.php';
        }
    }

    public static function getRouteCollection(): RouteCollection
    {
        return self::$routes;
    }

    public static function get(string $path, array|callable $action, array $options = []): void
    {
        self::addRoute($path, $action, 'GET', $options);
    }

    public static function post(string $path, array|callable $action, array $options = []): void
    {
        self::addRoute($path, $action, 'POST', $options);
    }

    public static function put(string $path, array|callable $action, array $options = []): void
    {
        self::addRoute($path, $action, 'PUT', $options);
    }

    public static function patch(string $path, array|callable $action, array $options = []): void
    {
        self::addRoute($path, $action, 'PATCH', $options);
    }

    public static function delete(string $path, array|callable $action, array $options = []): void
    {
        self::addRoute($path, $action, 'DELETE', $options);
    }

    public static function redirectTo(string $path, array $flashed = [], array $headers = []): void
    {
        $session = app()->resolve('_session');
        foreach ($flashed as $key => $value) {
            $session->getFlashBag()->set($key, $value);
        }
        foreach ($headers as $name => $value) {
            header($name . ': ' . $value);
        }
        http_response_code(303);
        header('Location: ' . $path);
        die();
    }
}
