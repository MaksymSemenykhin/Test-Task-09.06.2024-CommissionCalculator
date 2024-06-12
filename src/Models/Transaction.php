<?php

namespace CommissionCalculator\Models;

use CommissionCalculator\Enums\SupportedCurrencies;

class Transaction
{
    public static array $fieldsList = ['date', 'userId', 'userType', 'transactionType', 'amount', 'currency'];

    public function __construct(
        public readonly string $date,
        public readonly int $userId,
        public readonly string $userType,
        public readonly string $transactionType,
        public readonly float $amount,
        public readonly SupportedCurrencies $currency,
        public float $amountInEUR,
    ) {
    }
}
