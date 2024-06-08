<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;

class ConsoleOutput implements OutputInterface
{
    /**
     * Outputs the results to the console.
     *
     * @param array $results The results to output.
     * @return void
     */
    public function output(array $results): void
    {
        echo implode(PHP_EOL, $results) . PHP_EOL;
    }
}
