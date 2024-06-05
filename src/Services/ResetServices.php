<?php

namespace App\Services;

use App\Models\AccountModel;

class ResetServices
{
    private $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }

    public function reset()
    {
        $this->accountModel->resetAllAccounts();
        return [
            'msg' => 'OK',
            'statusCode' => 200
        ];

    }
}
