<?php

namespace App\Utils;

class Response 
{
    public static function json($response) 
    {
        http_response_code($response['statusCode']);
        if ($response['statusCode'] === 200 && empty($data)) {
            echo "OK";
        } else {
            header('Content-Type: application/json');
            echo json_encode($response['msg']);
        }
    }
}
