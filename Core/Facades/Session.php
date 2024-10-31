<?php

namespace Core\Facades;

/**
 * Handle application session.
 */
class Session
{
    /**
     * Start a new session.
     * @return bool
     */
    public static function start(): bool
    {
        return session_start();
    }

    /**
     * Get a param from session.
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set a new param on session.
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Regenerate the session_id.
     * @param bool $deleteOldSession
     * @return bool
     */
    public function regenerate(bool $deleteOldSession = false): bool
    {
        return session_regenerate_id($deleteOldSession);
    }

    /**
     * Unset a session param.
     * @param string $key
     * @return void
     */
    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy the current session.
     * @return bool
     */
    public function destroy(): bool
    {
        session_unset();
        return session_destroy();
    }
}
