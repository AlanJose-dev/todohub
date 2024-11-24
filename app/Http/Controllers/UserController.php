<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Facades\DB;
use App\Facades\View;
use App\Http\Router;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;

class UserController
{
    public function create()
    {
        View::make('users.create')->render();
    }

    public function store(Request $request)
    {
        // Validation.
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];
        $validator = Validation::createValidator();
        $violations = [
            'name' => $validator->validate($data['name'], [
                new Length(['min' => 4, 'max' => 255]),
                new NotNull(),
                new Type('string'),
                new Regex('/^[a-zA-Z0-9_-]{4,255}$/')
            ]),
            'email' => $validator->validate($data['email'], [
                new Length(['min' => 3, 'max' => 255]),
                new NotNull(),
                new Email(),
            ]),
            'password' => $validator->validate($data['password'], [
                new Length(['min' => 6, 'max' => 255]),
                new NotNull(),
            ]),
        ];
        $errors = [];

        foreach ($violations as $field => $fieldViolations) {
            foreach ($fieldViolations as $violation) {
                $errors[$field][] = $violation->getMessage();
            }
        }

        // Check for duplicate entries.
        $statement = DB::connection()
            ->prepare('select if(email, "true", "false") as is_duplicate_entry from users where email = :email');
        $statement->bindValue(':email', $data['email']);
        $statement->execute();
        $isDuplicateEntry = (bool)$statement->fetch();

        if ($isDuplicateEntry) {
            $errors['email'][] = 'This email is already in use.';
        }

        if (count(array_values($errors)) > 0) {
            Router::redirectTo('/register', flashed: [
                'errors' => $errors,
            ]);
        }

        // Data storing.
        //TODO: Store user and authenticate it.

//        Auth::authenticate();

        Router::redirectTo('/dashboard');
    }

    public function dashboard()
    {
        View::make('dashboard')->render();
    }
}
