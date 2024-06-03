<?php
// src/EventHandler.php
class EventHandler {
    public static function handleEvent() {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['type']) || !isset($input['amount'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $data = file_get_contents(__DIR__ . '/../data/balance.json');
        $balanceData = json_decode($data, true);

        switch ($input['type']) {
            case 'deposit':
                $balanceData['balance'] += $input['amount'];
                break;
            case 'withdraw':
                if ($balanceData['balance'] < $input['amount']) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Insufficient funds']);
                    return;
                }
                $balanceData['balance'] -= $input['amount'];
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid event type']);
                return;
        }

        file_put_contents(__DIR__ . '/../data/balance.json', json_encode($balanceData));
        echo json_encode(['balance' => $balanceData['balance']]);
    }
}
?>
