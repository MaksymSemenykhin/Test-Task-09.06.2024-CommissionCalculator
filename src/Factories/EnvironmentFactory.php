<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Enums\EnvironmentType;
use CommissionCalculator\Services\CommissionCalculator;
use CommissionCalculator\Services\CommissionCalculatorTests;
use RuntimeException;

/**
 * EnvironmentFactory is responsible for creating instances of CommissionCalculator or CommissionCalculatorTests
 * based on the provided environment configuration. This factory decides which calculator service to instantiate
 * by checking the existence of configuration files and selecting the appropriate one for production or testing.
 *
 * Methods:
 * - `create(array $configPair): CommissionCalculator|CommissionCalculatorTests`
 *   Creates an instance of either CommissionCalculator or CommissionCalculatorTests based on the configuration.
 *
 * Example:
 * ```
 * $factory = new EnvironmentFactory();
 * $calculator = $factory->create([new ConfigPair('config.php', 'config.backup.php')]);
 * ```
 *
 * @package CommissionCalculator\Factories
 */
class EnvironmentFactory
{
    /**
     * Creates a CommissionCalculator or CommissionCalculatorTests based on the environment configuration.
     *
     * @param array $configPair An array containing pairs of configuration filenames (main and backup).
     * @return CommissionCalculator|CommissionCalculatorTests The appropriate calculator instance based
     * on the environment.
     * @throws RuntimeException If no valid configuration file is found.
     */
    public function create(array $configPair): CommissionCalculator|CommissionCalculatorTests
    {
        $c1 = $configPair[0]->value;
        $c2 = $configPair[1]->value;
        $configFile = file_exists('config/' . $c1) ? 'config/' . $c1
            : (file_exists('config/' . $c2) ? 'config/' . $c2 : null);

        if (!$configFile) {
            throw new \RuntimeException("No valid configuration file found: '$c1' or '$c2'");
        }

        $config = require $configFile;
        $serviceFactory = new ServiceFactory($config);

        return match ($config['environment']) {
            EnvironmentType::Production => new CommissionCalculator($serviceFactory),
            EnvironmentType::Testing => new CommissionCalculatorTests($serviceFactory),
            default => throw new \InvalidArgumentException("Unsupported environment type: {$config['environment']}"),
        };
    }
}
