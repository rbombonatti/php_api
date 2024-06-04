<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Utils\Response;
use App\Utils\Validator;

class ResetController 
{
    private $accountModel;

    public function __construct() 
    {
        $this->accountModel = new AccountModel();
    }

    public function reset() 
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $this->accountModel->resetAllAccounts();
        Response::json('');
    }
}

