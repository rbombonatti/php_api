<?php

namespace App\Utils;

class Response 
{
    public static function json($response) 
    {
        http_response_code($response['statusCode']);
        header('Content-Type: application/json');
        echo json_encode($response['msg']);
    }

    public static function textHtml($response)
    {
        http_response_code($response['statusCode']);
        header('Content-Type: text/html');
        echo $response['msg'];
    }
}
