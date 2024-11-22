<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Facades\View;
use App\Http\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Validation;

class LoginController
{
    public function create()
    {
        View::make('auth.login')->render();
    }

    public function login(Request $request)
    {
        try
        {
            // Validation.
            $data = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];
            $validator = Validation::createValidator();
            $violations = [
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

            if(count(array_values($errors)) > 0) {
                Response::json([
                    'success' => false,
                    'errors' => $errors
                ], 400);
            }

            // Authentication.
            if(!Auth::attempt($data['email'], $data['password'])) {
                Response::json([
                   'success' => false,
                   'message' => 'Invalid credentials or user not exists.'
                ], 401);
            }

            dd($_SESSION['user']);
        }
        catch (\Exception $exception)
        {
            app()->resolve('_log')->error($exception->getMessage());
            Response::json([
                'success' => false,
                'errors' => 'Internal Server Error'
            ], 500);
        }
    }
}