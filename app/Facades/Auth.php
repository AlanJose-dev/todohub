<?php

namespace App\Facades;

class Auth
{
    public static function attempt($email, $password)
    {
        $statement = DB::connection()->prepare('select email, password from users where email = :email');
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
        $_SESSION['user'] = serialize($user);
        session_regenerate_id(true);
    }

    public static function check()
    {
        return isset($_SESSION['user']);
    }

    public static function logout()
    {
        $params = session_get_cookie_params();
        session_unset();
        session_destroy();
        setcookie(session_id(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
