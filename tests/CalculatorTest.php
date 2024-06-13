<?php

use CommissionCalculator\Abstracts\CalculatorTestAbstract;
/**
 * CalculatorTest validates the functionality of the commission calculation logic.
 * It extends `CalculatorTestAbstract` and provides methods to test the commission
 * calculation for different transaction scenarios using predefined input data and expected results.
 *
 * Methods:
 * - `testCalculateCommission()`
 *   Tests the commission calculation for a general set of transactions.
 *
 * - `testCalculatePrivateWithdrawWithFreeLimit()`
 *   Tests the commission calculation for private client withdrawals considering the weekly free limit.
 *
 * - `testCalculateBusinessWithdraw()`
 *   Tests the commission calculation for business client withdrawals.
 *
 * Example:
 * ```
 * phpunit --filter CalculatorTest
 * vendor/bin/phpunit tests
 * ```
 *
 * @package Tests
 */
class CalculatorTest extends CalculatorTestAbstract
{
    /**
     * Tests the commission calculation for a general set of transactions.
     */
    public function testCalculateCommission()
    {
        $expectedResults = [0.60, 3.00, 0.00, 0.06, 1.50, 0, 0.7, 0.31,0.30, 3.00, 0.00, 0.00, 8612];
        $this->testRunner->runTest('tests/input.csv', $expectedResults);
    }
    /**
     * Tests the commission calculation for private client withdrawals considering the weekly free limit.
     */
    public function testCalculatePrivateWithdrawWithFreeLimit()
    {
        $expectedResults = [0.0, 0.0, 0.0, 0.90, 0.0];
        $this->testRunner->runTest('tests/input_private_with_limit.csv', $expectedResults);
    }
    /**
     * Tests the commission calculation for business client withdrawals.
     */
    public function testCalculateBusinessWithdraw()
    {
        $expectedResults = [1.50];
        $this->testRunner->runTest('tests/input_business.csv', $expectedResults);
    }
}
