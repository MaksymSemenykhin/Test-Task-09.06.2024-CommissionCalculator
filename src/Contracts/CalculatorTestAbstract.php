<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Factories\EnvironmentFactory;
use CommissionCalculator\Enums\KnownConfigs;
use CommissionCalculator\Services\CommissionCalculator;
use CommissionCalculator\Services\CommissionCalculatorTests;
use PHPUnit\Framework;

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
