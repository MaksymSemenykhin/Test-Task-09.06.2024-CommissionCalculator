<?php

namespace CommissionCalculator\Abstracts;

use CommissionCalculator\Models\Transaction;

abstract class CommissionStrategyAbstract
{
    protected const COMMISSION_RATE = 0.000; // 0.3%
    protected ExchangeRateServiceAbstract $exchangeRateService;

    /**
     * Calculates the commission for a given transaction.
     *
     * @param Transaction $transaction
     * @return float The calculated commission.
     */
    abstract protected function calculateChargeableAmount(Transaction $transaction): float;
    public function __construct(ExchangeRateServiceAbstract $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    private function roundUp($amount, $currency)
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        return ceil($amount * pow(10, $decimalPlaces)) / pow(10, $decimalPlaces);
    }
    private function getDecimalPlaces($currency): int
    {
        return match ($currency) {
            'JPY' => 0,
            default => 2,
        };
    }
    public function calculate(Transaction $tr): float
    {
        $exchangeRateService = $this->exchangeRateService;
        $tr->amountInEUR = $exchangeRateService->convertToBase($tr->amount, $tr->currency);

        $chargeableAmount = $this->calculateChargeableAmount($tr);

        return $this->roundUp($exchangeRateService->convertFromBase($chargeableAmount, $tr->currency), $tr->currency);
    }
}
