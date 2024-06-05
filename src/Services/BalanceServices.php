<?php

namespace App\Services;

use App\Models\AccountModel;

class BalanceServices 
{
    private $accountModel;

    public function __construct() 
    {
        $this->accountModel = new AccountModel();
    }

    public function getBalance($accountId)
    {
        if (!$this->accountModel->accountExists($accountId)) {
            return [
                'msg' => 0,
                'statusCode' => 404
            ];
        }

        return [ 
            'msg' => $this->accountModel->getBalance(($accountId)), 
            'statusCode' => 200
        ];
    }
    
}