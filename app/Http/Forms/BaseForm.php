<?php

namespace App\Http\Forms;

use Symfony\Component\HttpFoundation\Request;

abstract class BaseForm
{
    private Request $request;

    private array $errors = [];

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    abstract public function validate(): bool;

    public function errors(): array
    {
        return $this->errors;
    }
}
