<?php

namespace CommissionCalculator\Models;

use CommissionCalculator\Attributes\Numeric;
use CommissionCalculator\Attributes\EnumValue;
use CommissionCalculator\Attributes\NotEmpty;
use CommissionCalculator\Enums\ClientsTypes;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Enums\SupportedOperations;

/**
 * Transaction represents a financial transaction with attributes validated by custom attributes.
 * This model is used for calculating commission fees for various types of transactions
 * such as deposits and withdrawals for private and business clients.
 *
 * Properties:
 * - `string $date` — The date of the transaction in `Y-m-d` format.
 * - `int $userId` — The user's unique identifier.
 * - `string|ClientsTypes $userType` — The type of user, either `private` or `business`.
 * - `string|SupportedOperations $transactionType` — The type of transaction, either `deposit` or `withdraw`.
 * - `float $amount` — The amount of the transaction.
 * - `string|SupportedCurrencies $currency` — The currency of the transaction.
 *
 * Attributes:
 * - `#[NotEmpty]`: Ensures the property is not empty.
 * - `#[Numeric]`: Ensures the property is numeric.
 * - `#[EnumValue(enumClass: ...)]`: Ensures the property value matches one of the values defined in the specified enum.
 *
 * Usage:
 * Instances of this class are validated upon creation to ensure they comply with required constraints,
 * such as being non-empty, numeric, or a valid enum value.
 *
 * Example:
 * ```
 * $transaction = new Transaction(
 *     '2024-01-01',
 *     1,
 *     ClientsTypes::PRIVATE,
 *     SupportedOperations::DEPOSIT,
 *     100.0,
 *     SupportedCurrencies::EUR,
 *     100.0
 * );
 * ```
 *
 * @package CommissionCalculator\Models
 */
class Transaction extends BaseModel
{
    #[NotEmpty]
    public string $date;

    #[NotEmpty, Numeric]
    public int $userId;

    #[NotEmpty, EnumValue(enumClass: ClientsTypes::class)]
    public string|ClientsTypes $userType;

    #[NotEmpty, EnumValue(enumClass: SupportedOperations::class)]
    public string|SupportedOperations $transactionType;

    #[NotEmpty, Numeric]
    public float $amount;

    #[NotEmpty, EnumValue(enumClass: SupportedCurrencies::class)]
    public string|SupportedCurrencies $currency;
}
