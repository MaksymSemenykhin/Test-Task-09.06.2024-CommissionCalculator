<?php

namespace CommissionCalculator\Services;

use CommissionCalculator\Contracts\CommissionCalculatorAbstract;
use CommissionCalculator\Factories\ServiceFactory;
use CommissionCalculator\Models\Transaction;

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
     * @return array
     */
    public function calculateCommissions(string $sourcePath): array
    {
        $calculatorFactory = $this->serviceFactory->createCalculatorFactory();
        $transactionRepository = $this->serviceFactory->createTransactionRepository($sourcePath);

        $transactions = $transactionRepository->getAllTransactions();
        $result = array_reduce($transactions, function ($carry, Transaction $transaction) use ($calculatorFactory) {
            $strategy = $calculatorFactory->create($transaction->transactionType, $transaction->userType);
            $carry[] = $strategy->calculate($transaction);
            return $carry;
        }, []);

        return $result;
    }
}
