<?php

namespace App\Facades;

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

    public static function authenticate(\stdClass $user)
    {
        Session::set('user', $user);
        session_regenerate_id(true);
    }

    public static function check()
    {
        return Session::has('user');
    }

    public static function user(): \stdClass
    {
        return Session::get('user');
    }

    public static function logout()
    {
        Session::destroy();
    }
}
