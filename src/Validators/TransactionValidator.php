<?php

namespace CommissionCalculator\Validators;

use CommissionCalculator\Contracts\ValidatorInterface;
use CommissionCalculator\Enums\SupportedCurrencies;

/**
TransactionValidator is a class for validating transaction data. It has a single method called validate,
If any validation errors are found, they are added to the $errors array, which is then returned by the validate method.
this is a simplified validation class added as an example
 */
class TransactionValidator implements ValidatorInterface
{
    /**
     * Validates transaction data.
     *
     * @param array $data The data to validate.
     * @return array List of validation errors, if any.
     */
    public function validate(array $data): array
    {
        $errors = [];

        // Validate date
        if (empty($data['date']) || !strtotime($data['date'])) {
            $errors[] = 'Invalid date format.';
        }

        // Validate userId
        if (empty($data['userId']) || !is_numeric($data['userId'])) {
            $errors[] = 'Invalid user ID.';
        }

        // Validate userType
        if (empty($data['userType']) || !in_array($data['userType'], ['private', 'business'], true)) {
            $errors[] = 'Invalid user type.';
        }

        // Validate transactionType
        if (empty($data['transactionType']) || !in_array($data['transactionType'], ['deposit', 'withdraw'], true)) {
            $errors[] = 'Invalid transaction type.';
        }

        // Validate amount
        if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
            $errors[] = 'Invalid amount.';
        }

        // Validate currency
        if (empty($data['currency']) || !in_array($data['currency'], SupportedCurrencies::casesString(), true)) {
            $errors[] = 'Invalid currency.';
        }

        return $errors;
    }
}
