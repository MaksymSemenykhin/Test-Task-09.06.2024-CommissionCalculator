<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Contracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Enums\SupportedCurrencies;

/**
 * The FixedExchangeRateService is a class that implements the ExchangeRateServiceAbstract contract.
 * It is responsible for providing fixed exchange rates for different currencies.
 * Used only for testing purposes and only EUR as base currency.
 */
class FixedExchangeRateService extends ExchangeRateServiceAbstract
{
    /**
     * FixedExchangeRateService constructor.
     *
     * @param array $rates Fixed exchange rates.
     */
    public function __construct(
        protected array $rates,
        protected SupportedCurrencies $baseCurrency = SupportedCurrencies::EUR
    ) {
    }

    /**
     * Fetches the exchange rates.
     *
     * @return array The exchange rates.
     */

    final public function fetchRates(): array
    {
        return $this->rates;
    }
}
