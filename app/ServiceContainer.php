<?php

namespace App;

class ServiceContainer
{
    private array $binds = [];

    private array $instances = [];

    public function bind(string $key, callable $resolver): void
    {
        $this->binds[$key] = $resolver;
    }

    public function resolve(string $key): mixed
    {
        if(array_key_exists($key, $this->instances)) {
            return $this->instances[$key];
        }

        if(!array_key_exists($key, $this->binds)) {
            // TODO: Throw a custom exception.
            die("Service container key '{$key}' not found");
        }

        $this->instances[$key] = call_user_func($this->binds[$key]);
        return $this->instances[$key];
    }

}
