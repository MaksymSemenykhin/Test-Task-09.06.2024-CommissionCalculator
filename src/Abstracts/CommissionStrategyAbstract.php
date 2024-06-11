<?php

namespace CommissionCalculator\Abstracts;

use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Models\Transaction;

abstract class CommissionStrategyAbstract
{
    protected const COMMISSION_RATE = 0.000;
    /**
     * Constructs a new instance of the CommissionStrategyAbstract class.
     *
     * @param ExchangeRateServiceAbstract $exchangeRateService The exchange rate service used for currency conversions.
     */
    public function __construct(protected ExchangeRateServiceAbstract $exchangeRateService)
    {
    }

    /**
     * Calculates the commission for a given transaction.
     *
     * @param Transaction $transaction
     * @return float The calculated commission.
     */
    abstract protected function calculateChargeableAmount(Transaction $transaction): float;

    /**
     * Rounds up the given amount to the number of decimal places of the specified currency.
     *
     * @param float $amount The amount to round up.
     * @param SupportedCurrencies $currency The currency to determine the number of decimal places.
     * @return float|int The rounded up amount.
     */
    private function roundUp(float $amount, SupportedCurrencies $currency): float|int
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        return ceil($amount * pow(10, $decimalPlaces)) / pow(10, $decimalPlaces);
    }

    /**
     * Returns the number of decimal places for a given currency.
     *
     * @param SupportedCurrencies $currency The currency code.
     * @return int The number of decimal places.
     */
    private function getDecimalPlaces(SupportedCurrencies $currency): int
    {
        return match ($currency) {
            SupportedCurrencies::JPY => 0,
            default => 2,
        };
    }
    /**
     * Calculates the commission for a given transaction.
     *
     * @param Transaction $tr The transaction object.
     * @return float The calculated commission.
     */
    public function calculate(Transaction $tr): float
    {
        $exchangeRateService = $this->exchangeRateService;
        $tr->amountInEUR = $exchangeRateService->convertToBase($tr->amount, $tr->currency);

        $chargeableAmount = $this->calculateChargeableAmount($tr);

        return $this->roundUp($exchangeRateService->convertFromBase($chargeableAmount, $tr->currency), $tr->currency);
    }
}
