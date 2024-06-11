<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;
use CommissionCalculator\Traits\RoundingTrait;

class ConsoleOutput implements OutputInterface
{
    use RoundingTrait;

    /**
     * Outputs the results to the console.
     *
     * @param array $results The results to output.
     * @return array|null
     */
    public function output(array $results): ?array
    {
        foreach ($results as $result) {
            echo $this->formatAmount($result['amount'], $result['currency']) . PHP_EOL;
        }
        return null;
    }
}
