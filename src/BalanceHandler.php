<?php

class BalanceHandler 
{

    const BALANCE_DATAFILE = '/../data/balance.json';

    public static function getBalance() 
    {
        $data = file_get_contents(__DIR__ . self::BALANCE_DATAFILE);
        $balance = json_decode($data, true)['balance'];
        header('Content-Type: application/json');
        echo json_encode(['balance' => $balance]);
    }
}
?>
