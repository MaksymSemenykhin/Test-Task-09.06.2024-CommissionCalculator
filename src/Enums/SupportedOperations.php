<?php

namespace CommissionCalculator\Enums;

/**
 * The Supported transaction types enum with aim to eliminate typos in transaction types
 *
 * @package CommissionCalculator\Enums
 */
enum SupportedOperations: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';

    /**
     * Returns an array of strings representing the values of all the cases in the SupportedOperations enum.
     *
     * @return array An array of strings.
     */
    public static function casesString(): array
    {
        return array_reduce(self::cases(), fn($carry, $case) => array_merge($carry, [$case->value]), []);
    }
}
