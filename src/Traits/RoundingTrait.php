<?php

namespace CommissionCalculator\Traits;

use CommissionCalculator\Enums\SupportedCurrencies;

/**
 * RoundingTrait provides utility methods for rounding and formatting numerical values
 * according to the decimal places required by various currencies.
 * This trait is designed to be used in classes that need consistent rounding and formatting logic.
 */
trait RoundingTrait
{
    /**
     * Rounds up the amount according to the currency's decimal places and formats it.
     *
     * @param float $amount The amount to round up.
     * @param SupportedCurrencies $currency The currency of the amount.
     * @return float|int The rounded and formatted amount.
     */
    private function roundUp(float $amount, SupportedCurrencies $currency): float|int
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        $result = ceil($amount * pow(10, $decimalPlaces)) / pow(10, $decimalPlaces);
        return $decimalPlaces === 0 ? (int) $result : (float) number_format($result, $decimalPlaces, '.', '');
    }

    /**
     * Gets the number of decimal places for a given currency.
     *
     * @param SupportedCurrencies $currency The currency.
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
