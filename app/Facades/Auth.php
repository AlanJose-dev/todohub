<?php

namespace App\Facades;

use App\Models\User;

class Auth
{
    public static function attempt($email, $password)
    {
        $statement = DB::connection()->prepare('select id, name, email, password from users where email = :email');
        $statement->bindParam(':email', $email);
        $statement->execute();
        $user = $statement->fetch();

        if(!$user || !password_verify($password, $user->password)) {
            return false;
        }

        // Replace by __sleep magic method on model.
        unset($user->password);
        self::authenticate($user);
        return true;
    }

    public static function authenticate(User $user)
    {
        $session = app()->resolve('_session');
        $session->set('user', $user);
        $session->migrate(true);
    }

    public static function check()
    {
        return app()->resolve('_session')->has('user');
    }

    public static function user(): ?User
    {
        return app()->resolve('_session')->get('user');
    }

    public static function logout()
    {
        app()->resolve('_session')->invalidate();
    }
}
