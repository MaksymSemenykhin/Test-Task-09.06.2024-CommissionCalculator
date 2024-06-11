<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Enums\SupportedCurrencies;

interface OutputInterface
{
    /**
     * Outputs the results.
     *
     * @param array $results The results to output.
     * @return array|null
     */
    public function output(array $results): ?array;
    public function formatAmount(float|int $amount, SupportedCurrencies $currency): string;
}
