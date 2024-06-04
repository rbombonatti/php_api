<?php

namespace App\Models;

class AccountModel 
{
    const EVENT_DEPOSIT = 'deposit';
    const EVENT_WITHDRAW = 'withdraw';
    const EVENT_TRANSFER = 'transfer';
    const EVENT_TYPES = [
        self::EVENT_DEPOSIT,
        self::EVENT_WITHDRAW,
        self::EVENT_TRANSFER
    ];

    private $filePath = __DIR__ . '/../../data/balance.json';

    private function readData() 
    {
        return json_decode(file_get_contents($this->filePath), true);
    }

    private function writeData($data) 
    {
        file_put_contents($this->filePath, json_encode($data));
    }

    public function getBalance($accountId) 
    {
        $data = $this->readData();
        foreach ($data as $account) {
            if ($account['id'] == $accountId) return $account['balance']; 
        }
        return 0;
    }

    public function updateBalance($accountId, $balance) 
    {
        $data = $this->readData();
        foreach ($data as $key => $account) {
            if ($account['id'] == $accountId) $data[$key]['balance'] = $balance; 
        }

        $this->writeData($data);
    }

    public function accountExists($accountId) 
    {
        $data = $this->readData();
        foreach ($data as $account) {
            if ($account['id'] == $accountId) return true; 
        }
        return false;
    }

    public function resetAllAccounts()
    {
        $data = [];
        $this->writeData($data);
    }

    public function createAccount($accountId, $amount)
    {
        $data = $this->readData();
        $newAccount = ['id' => $accountId, 'balance' => $amount];
        $data[] = $newAccount;
        $this->writeData($data);
        return $newAccount;
    }

}
