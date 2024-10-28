<?php

namespace Core\App;

/************************************************
 * The service container provides service bind to
 * resolve instances.
 ***********************************************/
class ServiceContainer
{
    /**
     * Keys pointing to instances resolvers.
     * @var array
     */
    private array $binds = [];

    /**
     * Already resolved instances.
     * @var array
     */
    private array $instances = [];

    /**
     * Set a service resolver identified by a key.
     * @param string $key
     * @param callable $resolver
     * @return void
     */
    public function bind(string $key, callable $resolver): void
    {
        $this->binds[$key] = $resolver;
    }

    /**
     * Returns a resolved service instance.
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function resolve(string $key): mixed
    {
        // If the service is already resolved returns it.
        if(array_key_exists($key, $this->instances)) {
            return $this->instances[$key];
        }

        // If the service is not bind throw an exception.
        if(!array_key_exists($key, $this->binds)) {
            throw new \Exception("Service container key '{$key}' not found");
        }

        // Resolve service instance and returns it.
        $this->instances[$key] = call_user_func($this->binds[$key]);
        return $this->instances[$key];
    }
}
