<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Utils\Response;
use App\Utils\Validator;

class EventController 
{
    private $accountModel;

    public function __construct() 
    {
        $this->accountModel = new AccountModel();
    }

    public function handleEvent() 
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $typeValidation = Validator::validateEventType($input, 'type');
        $amountValidation = Validator::validateNumericInput($input, 'amount');

        if (in_array($input['type'],  [AccountModel::EVENT_DEPOSIT, AccountModel::EVENT_WITHDRAW])) {
            $accountValidation = Validator::validateAccountId($input, 'destination');
            $destinationId = $input['destination'];
        }

        if (in_array($input['type'],  [AccountModel::EVENT_TRANSFER, AccountModel::EVENT_WITHDRAW])) {
            $accountValidation = Validator::validateAccountId($input, 'origin');
            $originId = $input['origin'];
            $destinationId = $input['destination'];
        }

        if (!$typeValidation['valid']) {
            Response::json(['error' => $typeValidation['message']], 400);
            return;
        }

        if (!$amountValidation['valid']) {
            Response::json(['error' => $amountValidation['message']], 400);
            return;
        }

        if (!$accountValidation['valid']) {
            Response::json(['error' => $accountValidation['message']], 400);
            return;
        }


        switch ($input['type']) {
            case AccountModel::EVENT_DEPOSIT:
                if (!$this->accountModel->accountExists($destinationId)) {
                    $newAccount = $this->accountModel->createAccount($destinationId, $input['amount']);
                    Response::json(['destination' => $newAccount], 201);
                    return;
                }
                $balance = $this->accountModel->getBalance($destinationId);
                $balance += $input['amount'];
                $this->accountModel->updateBalance($destinationId, $balance);
                Response::json( 
                    [
                    "destination" => 
                        [
                            "id" => $destinationId, 
                            "balance" => $balance
                        ]
                    ], 201);
                return;
                break;

            case AccountModel::EVENT_WITHDRAW:
                if (!$this->accountModel->accountExists($originId)) {
                    Response::json(0, 404);
                    return;
                }
                $balance = $this->accountModel->getBalance($originId);
                if ($balance < $input['amount']) {
                    Response::json(['error' => 'Insufficient funds'], 400);
                    return;
                }
                $balance -= $input['amount'];
                $this->accountModel->updateBalance($originId, $balance);
                Response::json(["origin" => ["id" => $originId, "balance" => $balance]], 201);
                return;
                break;

            case AccountModel::EVENT_TRANSFER:
                if (!$this->accountModel->accountExists($originId)) {
                    Response::json(0, 404);
                    return;
                }

                $originBalance = $this->accountModel->getBalance($originId);

                if ($originBalance < $input['amount']) {
                    Response::json('Insufficient funds', 404);
                    return;
                }

                if (!$this->accountModel->accountExists($destinationId)) {
                    $newAccount = $this->accountModel->createAccount($destinationId, 0);
                    $destinationId = $newAccount['id'];
                }


                $destionationBalance = $this->accountModel->getBalance($destinationId);

                $originBalance -= $input['amount'];
                $destionationBalance += $input['amount'];

                $this->accountModel->updateBalance($originId, $originBalance);
                $this->accountModel->updateBalance($destinationId, $destionationBalance);
                Response::json(
                    [
                        "origin" => [
                            "id" => $originId, 
                            "balance" => $originBalance
                        ],
                        "destination" => [
                            "id" => $destinationId, 
                            "balance" => $destionationBalance
                        ]
                    ], 201);
                return;
                break;

            default:
                Response::json(['error' => 'Invalid event type'], 400);
                return;
        }

    }
}

