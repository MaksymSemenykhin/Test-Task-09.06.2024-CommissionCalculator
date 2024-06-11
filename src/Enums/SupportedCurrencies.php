<?php

namespace CommissionCalculator\Enums;

/**
 * The Supported Currencies enum with aim to support currencies extension
 * and ensure there is no typos in Currencies codes
 */
enum SupportedCurrencies: string
{
    case EUR = 'EUR';
    case USD = 'USD';
    case JPY = 'JPY';

    /**
     * Returns an array of strings representing the values of all the cases in the SupportedCurrencies enum.
     *
     * @return array An array of strings.
     */
    public static function casesString(): array
    {
        return array_reduce(self::cases(), fn($carry, $case) => array_merge($carry, [$case->value]), []);
    }
}
