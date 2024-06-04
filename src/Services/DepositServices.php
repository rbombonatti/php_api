<?php

namespace App\Services;

use App\Models\AccountModel;

class DepositServices 
{
    private $accountModel;

    public function __construct() 
    {
        $this->accountModel = new AccountModel();
    }

    public function deposit($destinationId, $amount)
    {
        if (!$this->accountModel->accountExists($destinationId)) {
            $newAccount = $this->accountModel->createAccount($destinationId, $amount);
            return [
                'msg' => ['destination' => $newAccount],
                'statusCode' => 201
            ];
        }

        $balance = $this->accountModel->getBalance($destinationId);
        $balance += $amount;
        $this->accountModel->updateBalance($destinationId, $balance);
        return [
            'msg' => [
                "destination" => 
                    [
                        "id" => $destinationId, 
                        "balance" => $balance
                    ]
                ],
            'statusCode' => 201
        ];

    }
}