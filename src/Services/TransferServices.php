<?php

namespace App\Services;

use App\Models\AccountModel;

class TransferServices 
{
    private $accountModel;

    public function __construct() 
    {
        $this->accountModel = new AccountModel();
    }

    public function transfer($originId, $destinationId, $amount)
    {
        if (!$this->accountModel->accountExists($originId)) {
            return [
                'msg' => 0,
                'statusCode' => 404
            ];
        }

        $originBalance = $this->accountModel->getBalance($originId);

        if ($originBalance < $amount) {
            return [
                'msg' => 'Insufficient funds',
                'statusCode' => 404
            ];
        }

        if (!$this->accountModel->accountExists($destinationId)) {
            $newAccount = $this->accountModel->createAccount($destinationId, 0);
            $destinationId = $newAccount['id'];
        }


        $destionationBalance = $this->accountModel->getBalance($destinationId);

        $originBalance -= $amount;
        $destionationBalance += $amount;

        $this->accountModel->updateBalance($originId, $originBalance);
        $this->accountModel->updateBalance($destinationId, $destionationBalance);
        return [
            'msg' => [
                "origin" => [
                    "id" => $originId, 
                    "balance" => $originBalance
                ],
                "destination" => [
                    "id" => $destinationId, 
                    "balance" => $destionationBalance
                ]
            ],
            'statusCode' => 201
        ];
    }
}