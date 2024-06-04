<?php

class EventHandler 
{

    const BALANCE_DATAFILE = '/../data/balance.json';

    const EVENT_DEPOSIT = 'deposit';
    const EVENT_WITHDRAW = 'withdraw';
    const EVENT_TYPES = [
        self::EVENT_DEPOSIT,
        self::EVENT_WITHDRAW
    ];

    public static function handleEvent() 
    {
        $input = json_decode(file_get_contents('php://input'), true);

        self::validateType($input['type']);
        self::validateAmount($input['amount']);
        
        $data = file_get_contents(__DIR__ . self::BALANCE_DATAFILE);
        $balanceData = json_decode($data, true);

        switch ($input['type']) {

            case self::EVENT_DEPOSIT:
                $balanceData['balance'] += $input['amount'];
                break;

            case self::EVENT_WITHDRAW:
                self::validadeOperation($input['amount'], $balanceData['balance']);
                $balanceData['balance'] -= $input['amount'];
                break;

            default:
                http_response_code(500);
                echo json_encode(['error' => 'Invalid event type']);
                return;
        }

        file_put_contents(__DIR__ . self::BALANCE_DATAFILE, json_encode($balanceData));
        echo json_encode(['balance' => $balanceData['balance']]);
    }

    public static function validateType($type)
    {
        if (!isset($type) || ! in_array($type, self::EVENT_TYPES)) {
            http_response_code(400);
            echo json_encode(['error' => "$type is not a valid event type"]);
            exit;
        }

    }

    private static function validateAmount($amount)
    {
        $msg = false;
        if (!isset($amount)) {
            $msg = "Amount is required.";
        }

        if (!$msg && !is_numeric($amount)) {
            $msg = "Amount must be numeric.";
        }

        if (!$msg && $amount <= 0) {
            $msg = "Amount must be greater than zero.";
        }

        if ($msg) {
            http_response_code(400);
            echo json_encode(['error' => $msg]);
            exit;
        }
    }

    private static function validadeOperation($amount, $balance)
    {

        if ($balance < $amount) {
            http_response_code(400);
            echo json_encode(['error' => 'Insufficient funds']);
            exit;
        }

    }
}
?>
