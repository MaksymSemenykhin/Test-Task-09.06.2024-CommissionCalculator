<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Abstracts\CommissionCalculatorAbstract;
use CommissionCalculator\Factories\ServiceFactory;
use CommissionCalculator\Models\Transaction;

/**
 * CommissionCalculator is responsible for calculating commissions for transactions.
 * It utilizes a `ServiceFactory` to create necessary services and strategies for commission calculation.
 * This class extends `CommissionCalculatorAbstract` and provides a method to calculate commissions
 * from transactions obtained from a specified data source.
 *
 * Methods:
 * - `__construct(ServiceFactory $serviceFactory)`
 *   Initializes the calculator with a `ServiceFactory` to create necessary services and strategies.
 *
 * - `calculateCommissions(string $sourcePath): array`
 *   Calculates commissions for transactions from the given source path and returns the results.
 *
 * Example:
 * ```
 * $serviceFactory = new ServiceFactory($config);
 * $calculator = new CommissionCalculator($serviceFactory);
 * $results = $calculator->calculateCommissions('path/to/transactions.csv');
 * ```
 *
 * @package CommissionCalculator\Services
 */
class CommissionCalculator extends CommissionCalculatorAbstract
{
    /**
     * CommissionCalculator constructor.
     *
     * @param ServiceFactory $serviceFactory The service factory.
     */
    public function __construct(ServiceFactory $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * Calculates commissions for transactions from the given source path.
     *
     * @param string $sourcePath Path to the data source.
     * @return array An array of calculated commissions.
     */
    public function calculateCommissions(string $sourcePath): array
    {
        $calculatorFactory = $this->serviceFactory->createCalculatorFactory();
        $transactionRepository = $this->serviceFactory->createTransactionRepository($sourcePath);

        $transactions = $transactionRepository->getAllTransactions();
        return array_reduce($transactions, function ($carry, Transaction $transaction) use ($calculatorFactory) {
            $strategy = $calculatorFactory->create($transaction->transactionType, $transaction->userType);
            $carry[] = $strategy->calculate($transaction);
            return $carry;
        }, []);
    }
}
