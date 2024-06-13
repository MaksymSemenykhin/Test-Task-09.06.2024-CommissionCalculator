<?php

namespace CommissionCalculator\Traits;

use CommissionCalculator\Enums\SupportedCurrencies;

/**
 * RoundingTrait provides utility methods for rounding monetary amounts
 * to the appropriate decimal places based on the currency.
 *
 * Methods:
 * - `roundUp(float $amount, SupportedCurrencies $currency): float|int`
 *   Rounds up the given amount to the currency's decimal places and formats it appropriately.
 *
 * Example:
 * ```
 * use CommissionCalculator\Traits\RoundingTrait;
 *
 * class SomeClass {
 *     use RoundingTrait;
 *
 *     public function someMethod() {
 *         $amount = 123.456;
 *         $roundedAmount = $this->roundUp($amount, SupportedCurrencies::EUR);
 *     }
 * }
 * ```
 *
 * @package CommissionCalculator\Traits
 */
trait RoundingTrait
{
    /**
     * Rounds up the given amount to the currency's decimal places and formats it appropriately.
     *
     * @param float $amount The amount to round up.
     * @param SupportedCurrencies $currency The currency to determine the decimal places.
     * @return float|int The rounded amount, formatted according to the currency's precision.
     */
    private function roundUp(float $amount, SupportedCurrencies $currency): float|int
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        $result = ceil($amount * pow(10, $decimalPlaces)) / pow(10, $decimalPlaces);
        return $decimalPlaces === 0 ? (int) $result : (float) number_format($result, $decimalPlaces, '.', '');
    }

    /**
     * Returns the number of decimal places for the given currency.
     *
     * @param SupportedCurrencies $currency The currency to get the decimal places for.
     * @return int The number of decimal places.
     */
    private function getDecimalPlaces(SupportedCurrencies $currency): int
    {
        return match ($currency) {
            default => 2,
            SupportedCurrencies::JPY => 0,
        };
    }

    /**
     * Formats the amount according to the currency's decimal places.
     *
     * @param float|int $amount The amount to format.
     * @param SupportedCurrencies $currency The currency of the amount.
     * @return string The formatted amount.
     */
    public function formatAmount(float|int $amount, SupportedCurrencies $currency): string
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        return number_format($amount, $decimalPlaces, '.', '');
    }
}
