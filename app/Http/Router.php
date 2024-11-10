<?php

namespace App\Http;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private static RouteCollection $routes;

    public static function addRoute(string $name, Route $route, int $priority = 0): void
    {
        self::$routes->add($name, $route, $priority);
    }

    public static function loadRouteFiles(iterable ...$files): void
    {
        foreach ($files as $file) {
            require BASE_PATH . 'routes/' . $file . '.php';
        }
    }

    public static function getRouteCollection(): RouteCollection
    {
        return self::$routes;
    }
}
