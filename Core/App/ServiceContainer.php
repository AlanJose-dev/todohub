<?php

namespace Core\App;

use Core\Facades\Cache;

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
        // If service is cached returns it.
        if(Cache::has($key)) {
            return Cache::get($key);
        }

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
        Cache::set($key, $this->instances[$key]);
        return $this->instances[$key];
    }

    /**
     * Remove all cached services.
     * @return bool
     */
    public function clearCachedServices(): bool
    {
        foreach (array_keys($this->instances) as $key) {
            Cache::delete($key);
        }
        return true;
    }
}
