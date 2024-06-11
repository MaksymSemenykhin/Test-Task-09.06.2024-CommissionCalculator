<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Abstracts\CommissionCalculatorAbstract;
use CommissionCalculator\Enums\OutputType;
use CommissionCalculator\Factories\OutputFactory;
use CommissionCalculator\Factories\ServiceFactory;

use function PHPUnit\Framework\assertEquals;

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
