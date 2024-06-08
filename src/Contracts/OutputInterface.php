<?php

namespace CommissionCalculator\Contracts;

interface OutputInterface
{
    /**
     * Outputs the results.
     *
     * @param array $results The results to output.
     * @return void
     */
    public function output(array $results): void;
}
