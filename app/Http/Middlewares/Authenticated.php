<?php

namespace App\Http\Middlewares;

use App\Facades\Support\Auth;
use App\Http\Router;
use Symfony\Component\HttpFoundation\Request;

class Authenticated extends BaseMiddleware
{
    public function handle(Request $request): void
    {
        if(!Auth::check()) {
            Router::redirectTo('/login');
        }
    }
}