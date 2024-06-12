<?php

namespace CommissionCalculator\Models;

use CommissionCalculator\Enums\ClientsTypes;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Enums\SupportedOperations;

class Transaction
{
    public static array $fieldsList = ['date', 'userId', 'userType', 'transactionType', 'amount', 'currency'];

    public function __construct(
        public readonly string $date,
        public readonly int $userId,
        public readonly ClientsTypes $userType,
        public readonly SupportedOperations $transactionType,
        public readonly float $amount,
        public readonly SupportedCurrencies $currency,
        public float $amountInEUR,
    ) {
    }
}
