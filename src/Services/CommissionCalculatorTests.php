<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Abstracts\CommissionCalculatorAbstract;
use CommissionCalculator\Enums\OutputType;
use CommissionCalculator\Factories\OutputFactory;
use CommissionCalculator\Factories\ServiceFactory;
use Exception;

use function PHPUnit\Framework\assertEquals;

/**
 * CommissionCalculatorTests is responsible for testing the commission calculation functionality.
 * It extends `CommissionCalculatorAbstract` and provides methods to run tests on transactions
 * using a `ServiceFactory` to create necessary services and strategies.
 *
 * Properties:
 * - `CommissionCalculator $commissionCalculator` — Instance of `CommissionCalculator` used for calculating commissions.
 *
 * Methods:
 * - `__construct(ServiceFactory $serviceFactory)`
 *   Initializes the test class with a `ServiceFactory` and sets up an instance of `CommissionCalculator`.
 *
 * - `runTest(string $sourcePath, array $expectedResults): void`
 *   Runs a test for a given source path and compares the calculated results with expected results.
 *
 * Example:
 * ```
 * $serviceFactory = new ServiceFactory($config);
 * $testRunner = new CommissionCalculatorTests($serviceFactory);
 * $testRunner->runTest('path/to/test_transactions.csv', $expectedResults);
 * ```
 *
 * @package CommissionCalculator\Services
 */
class CommissionCalculatorTests extends CommissionCalculatorAbstract
{
    public CommissionCalculator $commissionCalculator;

    /**
     * CommissionCalculatorTests constructor.
     *
     * @param ServiceFactory $serviceFactory The service factory.
     */
    public function __construct(ServiceFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
        $this->commissionCalculator = new CommissionCalculator($serviceFactory);
    }

    /**
     * Runs the test for a given source path and expected results.
     *
     * @param string $sourcePath Path to the data source file.
     * @param array $expectedResults The expected results.
     * @throws Exception
     */
    public function runTest(string $sourcePath, array $expectedResults): void
    {
        $results = $this->commissionCalculator->calculateCommissions($sourcePath);

        $outputFactory = new OutputFactory();
        $outputHandler = $outputFactory->createOutputHandler(['type' => OutputType::Array]);
        $results = $outputHandler->output($results);

        assertEquals($expectedResults, $results, sprintf(
            "Test failed for %s\nExpected: %s\nGot: %s\n",
            $sourcePath,
            json_encode($expectedResults),
            json_encode($results)
        ));
    }
}
