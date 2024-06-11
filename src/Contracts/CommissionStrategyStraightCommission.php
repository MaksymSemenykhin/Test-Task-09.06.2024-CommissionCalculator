<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Abstracts\CommissionStrategyAbstract;
use CommissionCalculator\Models\Transaction;

class CommissionStrategyStraightCommission extends CommissionStrategyAbstract
{
    public function calculateChargeableAmount(Transaction $transaction): float
    {
        return $transaction->amountInEUR * static::COMMISSION_RATE;
    }
}
