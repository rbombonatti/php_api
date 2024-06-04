<?php

namespace App\Models;

class BalanceModel 
{

    const EVENT_DEPOSIT = 'deposit';
    const EVENT_WITHDRAW = 'withdraw';
    const EVENT_TYPES = [
        self::EVENT_DEPOSIT,
        self::EVENT_WITHDRAW
    ];

    private $filePath = __DIR__ . '/../../data/balance.json';

    public function getBalance() 
    {
        $data = json_decode(file_get_contents($this->filePath), true);
        return isset($data['balance']) ? $data['balance'] : 0;
    }

    public function updateBalance($balance) 
    {
        $data = ['balance' => $balance];
        file_put_contents($this->filePath, json_encode($data));
    }
}
