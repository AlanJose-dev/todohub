<?php

namespace App\Facades;

class Session
{
    public static function start()
    {
        session_start();
        return true;
    }

    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
        return true;
    }

    public static function get(string $key, mixed $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key)
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, mixed $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash()
    {
        unset($_SESSION['_flash']);
    }

    public static function flush()
    {
        $_SESSION = [];
    }

    public static function destroy()
    {
        self::flush();
        session_destroy();
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
