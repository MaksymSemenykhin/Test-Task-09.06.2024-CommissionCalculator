<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Enums\SupportedCurrencies;

/**
 * ExchangeRateServiceAbstract is an abstract for ExchangeRateService classes
 * It provides the following methods:
 *
 * fetchRates():
 * This method is abstract and should be implemented by the concrete classes.
 * It is responsible for fetching the exchange rates.
 *
 * convertToBase(float $amount, string $currency): float:
 * This method converts the given amount from the specified currency to base currency.
 * It first fetches the exchange rates and then performs the conversion.
 *
 * convertFromBase(float $amount, string $currency): float:
 * This method converts the given amount from base currency to the specified currency.
 * It first fetches the exchange rates and then performs the conversion.
 *
 */
abstract class ExchangeRateServiceAbstract
{
    protected SupportedCurrencies $baseCurrency;
    protected array $rates = [];
    abstract protected function fetchRates(): array;

    /**
     * Converts the given amount from the specified currency to base currency.
     *
     * @param float $amount The amount to be converted.
     * @param SupportedCurrencies $currency The currency of the amount.
     * @return float The converted amount in base currency.
     */
    public function convertToBase(float $amount, SupportedCurrencies $currency): float
    {
        $this->fetchRates();
        if (!isset($this->rates[$currency->value])) {
            throw new \InvalidArgumentException("Unsupported currency: $currency->value");
        }
        return $amount / $this->rates[$currency->value];
    }

    public function convertFromBase(float $amount, SupportedCurrencies $currency): float
    {
        $this->fetchRates();
        if (!isset($this->rates[$currency->value])) {
            throw new \InvalidArgumentException("Unsupported currency: $currency->value");
        }

        return $amount * $this->rates[$currency->value];
    }
}
