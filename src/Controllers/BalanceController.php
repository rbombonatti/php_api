<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Utils\Response;

class BalanceController 
{
    private $accountModel;

    public function __construct() 
    {
        $this->accountModel = new AccountModel();
    }

    public function getBalance($accountId) 
    {
        
        if (!$this->accountModel->accountExists($accountId)) {
            Response::json(0, 404);
            return;
        }

        $balance = $this->accountModel->getBalance($accountId);
        Response::json($balance);
    }
}
