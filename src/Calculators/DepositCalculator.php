<?php

namespace CommissionCalculator\Calculators;

use CommissionCalculator\Contracts\CommissionCalculatorInterface;
use CommissionCalculator\Models\Transaction;

class DepositCalculator implements CommissionCalculatorInterface
{
    /**
     * Calculates commission for a deposit transaction.
     *
     * @param array $transaction Transaction data.
     * @return float
     */
    public function calculate(Transaction $transaction): float
    {
        $amount = (float) $transaction->amount;
        $currency = $transaction->currency;

        return $this->roundUp($amount * 0.0003, $currency);
    }

    /**
     * Rounds up the amount to the currency's decimal places.
     *
     * @param float $amount Amount to round.
     * @param string $currency Currency code.
     * @return float
     */
    private function roundUp(float $amount, string $currency): float
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        return ceil($amount * pow(10, $decimalPlaces)) / pow(10, $decimalPlaces);
    }

    /**
     * Gets the number of decimal places for a currency.
     *
     * @param string $currency Currency code.
     * @return int
     */
    private function getDecimalPlaces(string $currency): int
    {
        return $currency === 'JPY' ? 0 : 2;
    }
}
