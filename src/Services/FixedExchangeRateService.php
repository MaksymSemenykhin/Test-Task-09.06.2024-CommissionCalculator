<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Enums\SupportedCurrencies;

/**
 * FixedExchangeRateService provides fixed exchange rates for different currencies.
 * This class extends `ExchangeRateServiceAbstract` and is primarily used for testing purposes
 * with a fixed set of rates and supports EUR as the base currency.
 *
 * Properties:
 * - `array $rates` — An associative array of fixed exchange rates.
 * - `SupportedCurrencies $baseCurrency` — The base currency for the exchange rates (default: EUR).
 *
 * Methods:
 * - `__construct(array $rates, SupportedCurrencies $baseCurrency = SupportedCurrencies::EUR)`
 *   Initializes the service with fixed exchange rates and a base currency.
 *
 * - `fetchRates(): array`
 *   Returns the fixed exchange rates.
 *
 * Example:
 * ```
 * $fixedRates = [
 *     'USD' => 1.12,
 *     'JPY' => 128.65,
 * ];
 * $service = new FixedExchangeRateService($fixedRates);
 * $rates = $service->fetchRates();
 * ```
 *
 * @package CommissionCalculator\Services
 */
class FixedExchangeRateService extends ExchangeRateServiceAbstract
{
    /**
     * FixedExchangeRateService constructor.
     *
     * @param array $rates Fixed exchange rates.
     * @param SupportedCurrencies $baseCurrency Base currency for exchange rates (default: EUR).
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
