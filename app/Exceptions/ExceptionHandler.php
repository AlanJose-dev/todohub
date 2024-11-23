<?php

namespace App\Exceptions;

class ExceptionHandler
{
    public function __invoke(\Throwable $exception)
    {
        header('Content-Type: text/html');
        app()->resolve('_log')->error($exception);
        app()->resolve('_exception_handler')->handleException($exception);
    }
}