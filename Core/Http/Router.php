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
     * Redirect the user to another route.
     * @param string $uri
     * @param array|null $flashData
     * @return void
     */
    public function redirect(string $uri, ?array $flashData = null)
    {
        http_response_code(303);
        header('Location: ' . $uri);
        // TODO: Add flash session.
        die();
    }

    /**
     * Get the last previous uri after redirect.
     * @return array
     */
    public function lastUri(): array
    {
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Handle the incoming request and define the suitable route.
     * @param string $requestUri
     * @param string $method
     * @return void
     */
    public function route(string $requestUri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $requestUri && $route['method'] === $method) {
                $controller = new $route['handler']['controller'];
                $action = $route['handler']['action'];
                $request = new Request();
                // TODO Implements a param_split system.
                call_user_func([$controller, $action], $request);
                die();
            }
        }
        http_response_code(404);
        die('Route not found');
    }
}
