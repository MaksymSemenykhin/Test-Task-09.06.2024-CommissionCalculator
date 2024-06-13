<?php

namespace CommissionCalculator\Repositories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Models\Transaction;
use CommissionCalculator\Validators\AttributeValidator;

/**
 * TransactionRepository is a class that is responsible for fetching and validating transactions from a data source.
 * It has two dependencies: DataSourceAdapterInterface and ValidatorInterface.
 */
readonly class TransactionRepository
{
    /**
     * TransactionRepository constructor.
     *
     * @param DataSourceAdapterInterface $dataSourceAdapter
     * @param AttributeValidator $validator
     *
     */
    public function __construct(
        private DataSourceAdapterInterface $dataSourceAdapter,
        private AttributeValidator $validator
    ) {
    }

    /**
     * Gets all transactions from the data source and converts them to Transaction objects after validation
     *
     * @return Transaction[]
     */
    public function getAllTransactions(): array
    {
        $rawData = $this->dataSourceAdapter->fetchTransactions();
        $transactions = [];

        foreach ($rawData as $data) {
            $transaction = new Transaction(...$data, amountInEUR: 0.0);
            $errors = $this->validator->validate($transaction);

            if (!empty($errors)) {
                throw new \InvalidArgumentException("Invalid transaction data: " . implode(', ', $errors));
            }
            $transactions[] = $transaction;
        }

        return $transactions;
    }
}
