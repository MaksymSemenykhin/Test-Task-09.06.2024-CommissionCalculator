<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;
use CommissionCalculator\Traits\RoundingTrait;

/**
 * ConsoleOutput formats and outputs results to the console.
 * This class is typically used for scenarios where the results need to be displayed
 * directly to the standard output. It utilizes the RoundingTrait to format amounts
 * according to the currency's precision before printing them.
 *
 * Methods:
 * - `output(array $results): ?array`
 *   Formats the results and outputs them to the console.
 *
 * @package CommissionCalculator\Outputs
 */
class ConsoleOutput implements OutputInterface
{
    use RoundingTrait;

    /**
     * Outputs the results to the console.
     *
     * @param array $results The results to output.
     * @return array|null Always returns null after outputting to console.
     */
    public function output(array $results): ?array
    {
        foreach ($results as $result) {
            echo $this->formatAmount($result['amount'], $result['currency']) . PHP_EOL;
        }
        return null;
    }
}
