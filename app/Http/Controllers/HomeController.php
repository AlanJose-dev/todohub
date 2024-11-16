<?php

namespace App\Http\Controllers;

use App\Facades\View;

class HomeController
{
    public function welcome()
    {
        View::make('welcome')->render();
    }
}
