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
            $response = [
                'msg' => '0',
                'statusCode' => 404                
            ];
            
        }

        $response['msg'] = $this->accountModel->getBalance($accountId);
        Response::json($response);
    }
}
