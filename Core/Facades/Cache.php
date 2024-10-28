<?php

namespace Core\Facades;

/****************************************************
 * Cache facade provides access to apcu resource.
 ***************************************************/
class Cache
{
    /**
     * If a ttl value is not passed the default is used.
     */
    public const int DEFAULT_TTL = 3600;

    /**
     * Get an item from cache.
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return apcu_fetch($key) ?? $default;
    }

    /**
     * Set a new item on cache.
     * @param string $key
     * @param mixed $value
     * @param int|\DateInterval|null $ttl
     * @return bool
     */
    public static function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        return apcu_store($key, $value, $ttl ?? self::DEFAULT_TTL);
    }

    /**
     * Delete an item from cache.
     * @param string $key
     * @return bool
     */
    public static function delete(string $key): bool
    {
        return apcu_delete($key);
    }

    /**
     * Remove all itens stored in cache.
     * @return bool
     */
    public static function clear(): bool
    {
        return apcu_clear_cache();
    }

    /**
     * Get multiple values from cache.
     * @param array $keys
     * @param mixed|null $default
     * @return array
     */
    public static function getMultiple(array $keys, mixed $default = null): array
    {
        $resolvedItems = [];
        foreach ($keys as $key) {
            $resolvedItems[$key] = self::get($key, $default);
        }
        return $resolvedItems;
    }

    /**
     * Set multiple values on cache.
     * @param array $values
     * @param int|\DateInterval|null $ttl
     * @return bool
     */
    public static function setMultiple(array $values, null|int|\DateInterval $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            self::set($key, $value, $ttl);
        }
        return true;
    }

    /**
     * Delete multiple values from cache.
     * @param array $keys
     * @return bool
     */
    public static function deleteMultiple(array $keys): bool
    {
        foreach ($keys as $key) {
            self::delete($key);
        }
        return true;
    }

    /**
     * Check if an item exists on cache.
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return apcu_exists($key);
    }
}
