<?php

namespace CommissionCalculator\Models;

use CommissionCalculator\Enums\ClientsTypes;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Enums\SupportedOperations;

/**
 * BaseModel provides a foundation for models that require validation attributes.
 * This abstract class ensures that all properties of derived models have at least
 * one validation attribute. If any property lacks validation attributes, an
 * InvalidArgumentException will be thrown during the object's instantiation.
 *
 * Example:
 * ```
 * class Transaction extends BaseModel
 * {
 *     #[NotEmpty]
 *     public string $date;
 *
 *     #[NotEmpty, Numeric]
 *     public int $userId;
 *
 *     #[NotEmpty, EnumValue(enumClass: UserType::class)]
 *     public string $userType;
 *
 *     #[NotEmpty, EnumValue(enumClass: TransactionType::class)]
 *     public string $transactionType;
 *
 *     #[NotEmpty, Numeric]
 *     public float $amount;
 *
 *     #[NotEmpty, EnumValue(enumClass: SupportedCurrencies::class)]
 *     public string $currency;
 *
 *     public function __construct(
 *         string $date,
 *         int $userId,
 *         string $userType,
 *         string $transactionType,
 *         float $amount,
 *         string $currency
 *     ) {
 *         parent::__construct();
 *         $this->date = $date;
 *         $this->userId = $userId;
 *         $this->userType = $userType;
 *         $this->transactionType = $transactionType;
 *         $this->amount = $amount;
 *         $this->currency = $currency;
 *     }
 * }
 * ```
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
