<?php

namespace App\Http\Middlewares;

use App\Http\Middlewares\BaseMiddleware;
use Symfony\Component\HttpFoundation\Request;

class CsrfToken extends BaseMiddleware
{

    public function handle(Request $request): void
    {
        $session = session();
        if(
            !$session->has('csrf_token') ||
            !hash_equals($session->get('csrf_token'), $request->get('_token'))
        ) {
            http_response_code(403);
            throw new \Exception('Invalid or missing CSRF token');
        }
    }
}