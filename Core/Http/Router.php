<?php

namespace Core\Http;

/**
 * Defines the application routes and handle it.
 */
class Router
{
    /**
     * The application stored routes.
     * @var array
     */
    private array $routes = [];

    /**
     * Add a new route.
     * @param array $route
     * @return void
     */
    private function add(array $route): void
    {
        $this->routes[] = $route;
    }

    public function get(string $uri, array $action, ?array $options = null): self
    {
        $this->add([
            'uri' => $uri,
            'method' => 'GET',
            'handler' => [
                'controller' => $action[0],
                'action' => $action[1]
            ],
            'middlewares' => $options['middlewares'] ?? [],
            'name' => $options['name'] ?? null,
        ]);
        return $this;
    }

    public function post(string $uri, array $action, ?array $options = null): self
    {
        $this->add([
            'uri' => $uri,
            'method' => 'POST',
            'handler' => [
                'controller' => $action[0],
                'action' => $action[1]
            ],
            'middlewares' => $options['middlewares'] ?? [],
            'name' => $options['name'] ?? null,
        ]);
        return $this;
    }

    public function put(string $uri, array $action, ?array $options = null): self
    {
        $this->add([
            'uri' => $uri,
            'method' => 'PUT',
            'handler' => [
                'controller' => $action[0],
                'action' => $action[1]
            ],
            'middlewares' => $options['middlewares'] ?? [],
            'name' => $options['name'] ?? null,
        ]);
        return $this;
    }

    public function patch(string $uri, array $action, ?array $options = null): self
    {
        $this->add([
            'uri' => $uri,
            'method' => 'PATCH',
            'handler' => [
                'controller' => $action[0],
                'action' => $action[1]
            ],
            'middlewares' => $options['middlewares'] ?? [],
            'name' => $options['name'] ?? null,
        ]);
        return $this;
    }

    public function delete(string $uri, array $action, ?array $options = null): self
    {
        $this->add([
            'uri' => $uri,
            'method' => 'DELETE',
            'handler' => [
                'controller' => $action[0],
                'action' => $action[1]
            ],
            'middlewares' => $options['middlewares'] ?? [],
            'name' => $options['name'] ?? null,
        ]);
        return $this;
    }

    /**
     * Handle the incoming request and define the suitable route.
     * @param string $requestUri
     * @param string $method
     * @return self
     */
    public function route(string $requestUri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $requestUri && $route['method'] === $method) {
                $controller = new $route['handler']['controller'];
                $action = $route['handler']['action'];
                call_user_func([$controller, $action]);
                die();
            }
        }
        http_response_code(404);
        die('Route not found');
    }
}
