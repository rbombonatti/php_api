<?php

namespace App\Utils;

class Response 
{
    public static function json($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        if ($statusCode === 200 && empty($data)) {
            echo "OK";
        } else {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
}
