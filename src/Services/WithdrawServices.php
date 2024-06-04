<?php

namespace App\Services;

use App\Models\AccountModel;

class WithdrawServices
{
    private $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    public function withdraw($originId, $amount)
    {
        if (!$this->accountModel->accountExists($originId)) {
            return [
                'msg' => 0,
                'statusCode' => 404
            ];
        }
        $balance = $this->accountModel->getBalance($originId);
        if ($balance < $amount) {
            return [
                'msg' => [
                    'error' => 'Insufficient funds'
                ],
                'statusCode' => 400
            ];
        }

        $balance -= $amount;
        $this->accountModel->updateBalance($originId, $balance);
        return [
            'msg' => [
                "origin" => [
                    "id" => $originId, 
                    "balance" => $balance
                ]
            ],
            'statusCode' => 201
        ];
    }
}
