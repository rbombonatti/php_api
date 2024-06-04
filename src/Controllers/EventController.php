<?php

namespace App\Controllers;

use App\Models\BalanceModel;
use App\Utils\Response;
use App\Utils\Validator;

class EventController {
    private $balanceModel;

    public function __construct() {
        $this->balanceModel = new BalanceModel();
    }

    public function handleEvent() {
        $input = json_decode(file_get_contents('php://input'), true);

        $typeValidation = Validator::validateEventType($input, 'type');
        $amountValidation = Validator::validateNumericInput($input, 'amount');

        if (!$typeValidation['valid']) {
            Response::json(['error' => $typeValidation['message']], 400);
            return;
        }

        if (!$amountValidation['valid']) {
            Response::json(['error' => $amountValidation['message']], 400);
            return;
        }

        $balance = $this->balanceModel->getBalance();

        switch ($input['type']) {
            case BalanceModel::EVENT_DEPOSIT:
                $balance += $input['amount'];
                break;

            case BalanceModel::EVENT_WITHDRAW:
                if ($balance < $input['amount']) {
                    Response::json(['error' => 'Insufficient funds'], 400);
                    return;
                }
                $balance -= $input['amount'];
                break;

            default:
                Response::json(['error' => 'Invalid event type'], 400);
                return;
        }

        $this->balanceModel->updateBalance($balance);
        Response::json(['balance' => $balance]);
    }
}
?>
