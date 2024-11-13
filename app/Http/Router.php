<?php

namespace App\Http;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private static RouteCollection $routes;

    private static function addRoute(string $path, array $action, string $method, array $options = []):void
    {
        self::$routes->add(
            $options['name'],
            new Route(
                $path,
                ['_controller' => $action[0], '_action' => $action[1]],
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

    public static function get(string $path, array $action, array $options = []): void
    {
        self::addRoute($path, $action, 'GET', $options);
    }

    public static function post(string $path, array $action, array $options = []): void
    {
        self::addRoute($path, $action, 'POST', $options);
    }

    public static function put(string $path, array $action, array $options = []): void
    {
        self::addRoute($path, $action, 'PUT', $options);
    }

    public static function patch(string $path, array $action, array $options = []): void
    {
        self::addRoute($path, $action, 'PATCH', $options);
    }

    public static function delete(string $path, array $action, array $options = []): void
    {
        self::addRoute($path, $action, 'DELETE', $options);
    }
}
