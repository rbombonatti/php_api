<?php

namespace App\Controllers;

use App\Utils\Response;
use App\Utils\Validator;
use App\Services\DepositServices;
use App\Services\WithdrawServices;
use App\Services\TransferServices;
use App\Models\AccountModel;

class EventController 
{
    private $depositServices;
    private $withdrawServices;
    private $transferServices;

    public function __construct() 
    {
        $this->depositServices = new DepositServices();
        $this->withdrawServices = new WithdrawServices();
        $this->transferServices = new TransferServices();
    }

    public function handleEvent() 
    {
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

        if (in_array($input['type'],  [AccountModel::EVENT_DEPOSIT, AccountModel::EVENT_WITHDRAW])) {
            $accountValidation = Validator::validateAccountId($input, 'destination');
            $destinationId = $input['destination'];
        }

        if (in_array($input['type'],  [AccountModel::EVENT_TRANSFER, AccountModel::EVENT_WITHDRAW])) {
            $accountValidation = Validator::validateAccountId($input, 'origin');
            $originId = $input['origin'];
            $destinationId = $input['destination'];
        }

        if (!$accountValidation['valid']) {
            Response::json(['error' => $accountValidation['message']], 400);
            return;
        }

        switch ($input['type']) {
            case AccountModel::EVENT_DEPOSIT:
                $response = $this->depositServices->deposit($destinationId, $input['amount']);
            break;

            case AccountModel::EVENT_WITHDRAW:
                $response = $this->withdrawServices->withdraw($originId, $input['amount']);
            break;

            case AccountModel::EVENT_TRANSFER:
                $response = $this->transferServices->transfer($originId, $destinationId, $input['amount']);
                break;

            default:
                $response = [
                    'msg' => 'Invalid event type',
                    'statusCode' => 400
                ];
        }

        return Response::json($response);

    }
}

