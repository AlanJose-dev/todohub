<?php

namespace Core\Http;

use Core\Http\Interfaces\BagInterface;

/**
 * Stores and handle the request payload.
 */
class InputBag implements BagInterface
{
    private array $payload = [];

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Get an item from bag.
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->payload[$key] ?? $default;
    }

    /**
     * Set a bag item.
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->payload[$key] = $value;
    }

    /**
     * Checks if the item exists in the bag.
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->payload);
    }

    /**
     * Remove an item from bag.
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        unset($this->payload[$key]);
    }
}
