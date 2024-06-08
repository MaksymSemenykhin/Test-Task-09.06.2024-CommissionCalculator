<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Enums\EnvironmentType;
use CommissionCalculator\Services\CommissionCalculator;
use CommissionCalculator\Services\CommissionCalculatorTests;

/**
 * The EnvironmentFactory is responsible for creating instances of the CommissionCalculator or CommissionCalculatorTests
 * classes based on the environment configuration. The `create` method takes an array of `configPair` objects, each
 * containing a production and a testing configuration.
 *
 * The `configPair` objects are expected to contain the two configuration, main and backup, arrays for the environment.
 * Class first checks if the main configuration file exists, and if not, it falls back to the backup
 * configuration file
 *
 * The `create` method returns an instance of the CommissionCalculator or CommissionCalculatorTests
 **/
class EnvironmentFactory
{
    /**
     * Creates a CommissionCalculator or CommissionCalculatorTests based on the environment.
     *
     * @param $configPair
     * @return CommissionCalculator|CommissionCalculatorTests
     */
    public function create($configPair): CommissionCalculator|CommissionCalculatorTests
    {
        $c1 = $configPair[0]->value;
        $c2 = $configPair[1]->value;
        $configFile = file_exists('config/' . $c1) ? 'config/' . $c1 : 'config/' . $c2;
        $config = require $configFile;
        $serviceFactory = new ServiceFactory($config);

        return match ($config['environment']) {
            EnvironmentType::Production => new CommissionCalculator($serviceFactory),
            EnvironmentType::Testing => new CommissionCalculatorTests($serviceFactory),
        };
    }
}
