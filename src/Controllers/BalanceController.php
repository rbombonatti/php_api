<?php

namespace App\Controllers;

use App\Services\BalanceServices;
use App\Utils\Response;

class BalanceController 
{
    private $balanceServices;

    public function __construct() 
    {
        $this->balanceServices = new BalanceServices();
    }

    public function getBalance($accountId) 
    {
        $response = $this->balanceServices->getBalance($accountId);
        Response::textHtml($response);
    }
}
