<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;
use CommissionCalculator\Traits\RoundingTrait;

/**
 * ArrayOutput formats and outputs results to an array.
 * This class is typically used for scenarios where the results need to be collected
 * in memory rather than displayed or written to a file. It utilizes the RoundingTrait
 * to format amounts according to the currency's precision.
 *
 * Methods:
 * - `output(array $results): array`
 *   Formats the results and returns them as an array.
 *
 * @package CommissionCalculator\Outputs
 */
readonly class ArrayOutput implements OutputInterface
{
    use RoundingTrait;

    /**
     * Outputs the results to an array.
     *
     * @param array $results The results to output.
     * @return array
     */
    public function output(array $results): array
    {
        $resultsFormated = [];
        foreach ($results as $result) {
            $resultsFormated[] = $this->formatAmount($result['amount'], $result['currency']) . PHP_EOL;
        }
        return $resultsFormated;
    }
}
