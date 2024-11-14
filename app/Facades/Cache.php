<?php

namespace App\Facades;

class Cache
{
    public static function set(string $key, mixed $value, ?int $ttl = null): bool
    {
        return apcu_store($key, $value, $ttl ?? 0);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return apcu_fetch($key, $default);
    }

    public static function has(string $key): bool
    {
        return apcu_exists($key);
    }

    public static function setMultiple(iterable $values, ?int $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            self::set($key, $value, $ttl);
        }
        return true;
    }

    public static function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $itemsRetrievedFromCache = [];
        foreach ($keys as $key) {
            $itemsRetrievedFromCache[$key] = self::get($key, $default);
        }
        return $itemsRetrievedFromCache;
    }

    public static function delete(string $key): bool
    {
        return apcu_delete($key);
    }

    public static function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            self::delete($key);
        }
        return true;
    }

    public static function clear(): bool
    {
        return apcu_clear_cache();
    }
}