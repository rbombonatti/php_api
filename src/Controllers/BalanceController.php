<?php

namespace App\Controllers;

use App\Models\BalanceModel;
use App\Utils\Response;

class BalanceController {
    private $balanceModel;

    public function __construct() {
        $this->balanceModel = new BalanceModel();
    }

    public function getBalance() {
        $balance = $this->balanceModel->getBalance();
        Response::json(['balance' => $balance]);
    }
}
?>
