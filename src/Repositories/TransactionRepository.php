<?php

namespace CommissionCalculator\Repositories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Contracts\ValidatorInterface;
use CommissionCalculator\Enums\ClientsTypes;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Enums\SupportedOperations;
use CommissionCalculator\Models\Transaction;

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
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private DataSourceAdapterInterface $dataSourceAdapter,
        private ValidatorInterface $validator
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
            $errors = $this->validator->validate($data);
            if (!empty($errors)) {
                throw new \InvalidArgumentException("Invalid transaction data: " . implode(', ', $errors));
            }

            $transactions[] = new Transaction(
                $data['date'],
                (int)$data['userId'],
                ClientsTypes::from($data['userType']),
                SupportedOperations::from($data['transactionType']),
                (float)$data['amount'],
                SupportedCurrencies::from($data['currency']),
                0.0,
            );
        }

        return $transactions;
    }
}
