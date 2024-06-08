<?php

use CommissionCalculator\Contracts\CalculatorTestAbstract;

class CalculatorTest extends CalculatorTestAbstract
{

    public function testCalculateCommission()
    {
        $expectedResults = [0.60, 3.00, 0.00, 0.06, 1.50, 0.00, 0.7, 0.31,0.30, 3.00, 0.00, 0.00, 8611.42];
        $this->testRunner->runTest('tests/input.csv', $expectedResults);
    }

    public function testCalculatePrivateWithdrawWithFreeLimit()
    {
        $expectedResults = [0.0, 0.0, 0.0, 0.90, 0.0];
        $this->testRunner->runTest('tests/input_private_with_limit.csv', $expectedResults);
    }

    public function testCalculateBusinessWithdraw()
    {
        $expectedResults = [1.50];
        $this->testRunner->runTest('tests/input_business.csv', $expectedResults);
    }
}
