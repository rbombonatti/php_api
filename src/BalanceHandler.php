<?php
// src/BalanceHandler.php
class BalanceHandler {
    public static function getBalance() {
        $data = file_get_contents(__DIR__ . '/../data/balance.json');
        $balance = json_decode($data, true)['balance'];
        header('Content-Type: application/json');
        echo json_encode(['balance' => $balance]);
    }
}
?>
