<?php

namespace Core\Http\Controllers;

use Core\Http\Request;

class HomeController
{
    public function home(): void
    {
        echo "<h1>Hello World!</h1>";
    }
}
