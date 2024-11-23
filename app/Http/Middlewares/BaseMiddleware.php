<?php

namespace App\Http\Middlewares;

use Symfony\Component\HttpFoundation\Request;

abstract class BaseMiddleware
{
    public abstract function handle(Request $request): void;
}
