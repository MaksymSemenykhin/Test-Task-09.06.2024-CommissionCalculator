<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Abstracts\CommissionStrategyAbstract;
use CommissionCalculator\Models\Transaction;

/**
 * Abstract class for implementing more simplified commission strategies.
 * @package CommissionCalculator\Contracts
 */
class CommissionStrategyStraightCommission extends CommissionStrategyAbstract
{
    /**
     * Calculates the chargeable amount for a given amount in base currency.
     *
     * @param Transaction $transaction
     * @return float The chargeable amount calculated by multiplying the given amount by the commission rate.
     */
    public function calculateChargeableAmount(Transaction $transaction): float
    {
        return $transaction->amountInEUR * static::COMMISSION_RATE;
    }
}
