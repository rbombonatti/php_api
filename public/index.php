<?php
// public/index.php
require_once __DIR__ . '/../src/BalanceHandler.php';
require_once __DIR__ . '/../src/EventHandler.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

if ($uri === '/balance' && $method === 'GET') {
    BalanceHandler::getBalance();
} elseif ($uri === '/event' && $method === 'POST') {
    EventHandler::handleEvent();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
}
?>
