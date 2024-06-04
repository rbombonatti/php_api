<?php

require_once __DIR__ . '/../autoload.php';

use App\Controllers\BalanceController;
use App\Controllers\EventController;
use App\Controllers\ResetController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/balance' && $method === 'GET') {
    (new BalanceController())->getBalance($_GET['account_id']);

} elseif ($uri === '/event' && $method === 'POST') {
    (new EventController())->handleEvent();

} elseif ($uri === '/reset' && $method === 'POST') {
    (new ResetController())->reset();

} else {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}

