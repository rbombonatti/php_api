<?php

namespace App\Utils;

use App\Models\BalanceModel;

class Validator {

    public static function validateEventType($input, $fieldName) {
        if (! isset($input[$fieldName])) {
            return ['valid' => false, 'message' => "$fieldName is required."];
        }

        if (! in_array($input[$fieldName], BalanceModel::EVENT_TYPES)) {
            return ['valid' => false, 'message' => "$input[$fieldName] is not a valid operation."];
        }

        return ['valid' => true, 'message' => ''];
    }

    public static function validateNumericInput($input, $fieldName) {
        if (! isset($input[$fieldName])) {
            return ['valid' => false, 'message' => "$fieldName is required."];
        }

        if (! is_numeric($input[$fieldName])) {
            return ['valid' => false, 'message' => "$fieldName must be numeric."];
        }

        if ($input[$fieldName] <= 0) {
            return ['valid' => false, 'message' => "$fieldName must be greater than zero."];
        }

        return ['valid' => true, 'message' => ''];
    }
}
?>
