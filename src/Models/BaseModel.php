<?php

namespace CommissionCalculator\Models;

use CommissionCalculator\Enums\ClientsTypes;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Enums\SupportedOperations;

/**
 * BaseModel serves as a foundational class for models that require validation and consistent representation.
 * This abstract class ensures that all properties of derived models adhere to specific types and conversions,
 * including enumeration validation. It also provides a standard list of fields used in transaction models.
 *
 * Properties:
 * - `public string $date` — The date of the transaction.
 * - `public int $userId` — The user's unique identifier.
 * - `public string|ClientsTypes $userType` — The type of user, either `private` or `business`.
 * - `public string|SupportedOperations $transactionType` — The type of transaction, either `deposit` or `withdraw`.
 * - `public float $amount` — The amount of the transaction.
 * - `public string|SupportedCurrencies $currency` — The currency of the transaction.
 * - `public float $amountInEUR` — The amount of the transaction converted to EUR.
 *
 * @package CommissionCalculator\Models
 */
abstract class BaseModel
{
    public static array $fieldsList = ['date', 'userId', 'userType', 'transactionType', 'amount', 'currency'];
    public function __construct(
        public string $date,
        public int $userId,
        public string|ClientsTypes $userType,
        public string|SupportedOperations $transactionType,
        public float $amount,
        public string|SupportedCurrencies $currency,
        public float $amountInEUR,
    ) {
        $this->userType = ClientsTypes::from($userType);
        $this->transactionType = SupportedOperations::from($transactionType);
        $this->currency = SupportedCurrencies::from($currency);
    }
}
