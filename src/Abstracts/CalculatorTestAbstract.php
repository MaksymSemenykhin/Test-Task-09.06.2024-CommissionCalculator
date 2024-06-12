<?php

namespace CommissionCalculator\Abstracts;

use CommissionCalculator\Enums\KnownConfigs;
use CommissionCalculator\Factories\EnvironmentFactory;
use CommissionCalculator\Services\CommissionCalculator;
use CommissionCalculator\Services\CommissionCalculatorTests;
use PHPUnit\Framework;

/**
 * CalculatorTestAbstract is a base for CalculatorTest implementations, which are used to test the application.
 * It is Required to contain common tests functions
 *
 * @package CommissionCalculator\Abstracts
 */
class CalculatorTestAbstract extends Framework\TestCase
{
    protected CommissionCalculator|CommissionCalculatorTests $testRunner;
    /**
     * Sets up the test runner based on Tests or Main configurations
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->testRunner = (new EnvironmentFactory())->create([KnownConfigs::Tests,KnownConfigs::Main]);
    }
}
