<?php

require_once __DIR__ . '/../autoload.php';

use App\Controllers\BalanceController;
use App\Controllers\EventController;
use App\Controllers\ResetController;
use App\Utils\Response;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$notFound = false;

if ($method === 'GET') {
    switch ($uri) {
        case '/balance':
            (new BalanceController())->getBalance($_GET['account_id']);
            break;

        default:
            $notFound = true;
            break;
    }
}

if ($method === 'POST') {
    switch ($uri) {
        case '/event':
            (new EventController())->handleEvent();
            break;

        case '/reset':
            (new ResetController())->reset();
            break;

        default:
            $notFound = true;
            break;
    }
}

if ($notFound) {
    Response::json([
        'msg' => 'Endpoint not found',
        'statusCode' => 404
    ]);
}
