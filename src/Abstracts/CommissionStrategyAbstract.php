<?php

namespace CommissionCalculator\Abstracts;

use CommissionCalculator\Models\Transaction;
use CommissionCalculator\Traits\RoundingTrait;

/**
 * Abstract class for implementing different commission strategies.
 *
 * The CommissionStrategyAbstract class provides a common interface
 * for calculating the commission for a given transaction.
 * It serves as a base for implementing specific commission strategies.
 *
 * @package CommissionCalculator\Abstracts
 */
abstract class CommissionStrategyAbstract
{
    use RoundingTrait;

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
     * Calculates the chargeable amount for a given amount in base currency.
     *
     * @param Transaction $transaction
     * @return float The chargeable amount.
     */
    abstract protected function calculateChargeableAmount(Transaction $transaction): float;

    /**
     * Calculates the commission for a given transaction.
     *
     * @param Transaction $tr The transaction object.
     * @return array The calculated commission.
     */
    public function calculate(Transaction $tr): array
    {
        $exchangeRateService = $this->exchangeRateService;
        $tr->amountInEUR = $exchangeRateService->convertToBase($tr->amount, $tr->currency);

        $chargeableAmount = $this->calculateChargeableAmount($tr);
        return [
            'amount' => $this->roundUp(
                $exchangeRateService->convertFromBase($chargeableAmount, $tr->currency),
                $tr->currency
            ),
            'currency' => $tr->currency,
        ];
    }
}
