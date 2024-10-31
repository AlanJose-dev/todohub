<?php

namespace Core\Http\Interfaces;

/**
 * Bag pattern contract.
 */
interface BagInterface
{
    /**
     * Get an item from bag.
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Set a bag item.
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void;

    /**
     * Checks if the item exists in the bag.
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Remove an item from bag.
     * @param string $key
     * @return void
     */
    public function remove(string $key): void;
}
