<?php

namespace App\Http;

class Response
{
    public static function json(array $payload, int $status = 200, array $headers = []): void
    {
        $jsonData = json_encode($payload, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json');
        foreach ($headers as $header => $value) {
            header("$header: $value");
        }
        http_response_code($status);
        echo $jsonData;
        die();
    }
}
