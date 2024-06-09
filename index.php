<?php
/**
 * This is the entry point of the CommissionCalculator application.

 * usage:
 * php index.php [path/path/to/data_source.csv]

 * @package CommissionCalculator
 * @author semenykhin maksym
 * @license MIT License
 */

/**
 * Require the Composer autoloader.
 *
 * This allows the application to autoload classes and dependencies defined in the composer.json file.
 */
require 'vendor/autoload.php';

/**
 * Import specific classes from the CommissionCalculator namespace.
 *
 * These classes are used later in the code.
 */
use CommissionCalculator\Factories\EnvironmentFactory;
use CommissionCalculator\Factories\OutputFactory;
use CommissionCalculator\Enums\KnownConfigs;

try {

    // EnvironmentFactory Create an instance of the commissionCalculator(prod or tests) class.
    // Factory choice depends on config variable `environment` which is type of CommissionCalculator\Enums\EnvironmentType
    // At the moment there are two $commissionCalculator implementations `CommissionCalculator` and `CommissionCalculatorTests`
    // One For general purposes and second for testing;
    $commissionCalculator = (new EnvironmentFactory())->create([KnownConfigs::Local,KnownConfigs::Main]);
    $config = $commissionCalculator->getConfig();

    // Path to the data source is passed as a command line argument or from config
    $sourcePath = $argv[1] ?? $config['data_source']['path'];

    // Calculate commissions
    $results = $commissionCalculator->calculateCommissions($sourcePath);

    // OutputFactory creates an instance CommissionCalculator\Contracts\OutputInterface
    // Factory choice depends on config variable `output.type` which is type of CommissionCalculator\Enums\OutputType
    // At the moment there are tree OutputInterface implementations `ConsoleOutput`, `TextFileOutput` and `XmlFileOutput`
    $outputFactory = new OutputFactory();
    $outputHandler = $outputFactory->createOutputHandler($config['output']);
    $outputHandler->output($results);



} catch (\Exception $e) {
    echo 'Failed to calculate commissions: ';
    echo $e->getMessage();
}
