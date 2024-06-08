<?php

require 'vendor/autoload.php';

use CommissionCalculator\Factories\EnvironmentFactory;
use CommissionCalculator\Factories\OutputFactory;
use CommissionCalculator\Enums\KnownConfigs;

// Create CommissionCalculator based on environment
$commissionCalculator = (new EnvironmentFactory())->create([KnownConfigs::Local,KnownConfigs::Main]);
$config = $commissionCalculator->getConfig();

// Path to the data source is passed as a command line argument or from config
$sourcePath = $argv[1] ?? $config['data_source']['path'];

// Calculate commissions
$results = $commissionCalculator->calculateCommissions($sourcePath);

// Output results using OutputFactory
$outputFactory = new OutputFactory();
$outputHandler = $outputFactory->createOutputHandler($config['output']);
$outputHandler->output($results);

