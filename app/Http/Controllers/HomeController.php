<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Request;

class HomeController
{
    public function welcome()
    {
        header('Content-type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'I\'m alive!',
        ]);
    }
}
