<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;
use CommissionCalculator\Traits\RoundingTrait;

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
