<?php

namespace App\Facades\Support;

use App\Models\User;

class Auth
{
    public static function attempt($email, $password)
    {
        $user = User::select([
            'id', 'name', 'email', 'password'
        ],
        [
            'email.=' => $email
        ])->first();

        if(!$user || !password_verify($password, $user->password)) {
            return false;
        }

        unset($user->password);
        self::authenticate($user);
        return true;
    }

    public static function authenticate(User $user)
    {
        $session = session();
        $session->set('user', $user);
        $session->migrate(true);
    }

    public static function check()
    {
        return session()->has('user');
    }

    public static function user(): ?User
    {
        return session()->get('user');
    }

    public static function logout()
    {
        $params = session_get_cookie_params();
        session()->clear();
        session()->invalidate();
        setcookie(
            session()->getName(),
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
}
