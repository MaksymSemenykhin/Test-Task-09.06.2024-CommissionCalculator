<?php

namespace CommissionCalculator\Repositories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Models\Transaction;
use CommissionCalculator\Validators\AttributeValidator;

/**
 * TransactionRepository is responsible for fetching, validating, and converting raw transaction data
 * from a data source into `Transaction` objects. It relies on a data source adapter to fetch the data
 * and an attribute validator to ensure data integrity.
 *
 * Dependencies:
 * - `DataSourceAdapterInterface $dataSourceAdapter`: Fetches raw transaction data from the source.
 * - `AttributeValidator $validator`: Validates transaction data against defined attributes.
 *
 * Methods:
 * - `getAllTransactions(): array`
 *   Fetches, validates, and returns all transactions from the data source as `Transaction` objects.
 *
 * Example:
 * ```
 * $dataSourceAdapter = new CsvDataSourceAdapter('path/to/file.csv', Transaction::$fieldsList);
 * $validator = new AttributeValidator();
 * $repository = new TransactionRepository($dataSourceAdapter, $validator);
 * $transactions = $repository->getAllTransactions();
 * ```
 *
 * @package CommissionCalculator\Repositories
 */
readonly class TransactionRepository
{
    /**
     * TransactionRepository constructor.
     *
     * @param DataSourceAdapterInterface $dataSourceAdapter Adapter for fetching raw transaction data.
     * @param AttributeValidator $validator Validator for ensuring transaction data integrity.
     */
    public function __construct(
        private DataSourceAdapterInterface $dataSourceAdapter,
        private AttributeValidator $validator
    ) {
    }

    /**
     * Gets all transactions from the data source, validates, and converts them to `Transaction` objects.
     *
     * @return Transaction[] An array of validated `Transaction` objects.
     * @throws \InvalidArgumentException If any transaction data is invalid.
     */
    public function getAllTransactions(): array
    {
        $rawData = $this->dataSourceAdapter->fetchTransactions();
        $transactions = [];

        foreach ($rawData as $data) {
            // Create a Transaction object with validated data
            $transaction = new Transaction(...$data, amountInEUR: 0.0);
            // Validate the transaction
            $errors = $this->validator->validate($transaction);

            if (!empty($errors)) {
                throw new \InvalidArgumentException("Invalid transaction data: " . implode(', ', $errors));
            }

            $transactions[] = $transaction;
        }

        return $transactions;
    }
}
