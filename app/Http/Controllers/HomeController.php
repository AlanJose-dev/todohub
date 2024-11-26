<?php

namespace App\Http\Controllers;

use App\Facades\Support\View;

class HomeController
{
    public function welcome()
    {
        View::make('welcome')->render();
    }
}
