<?php

namespace CommissionCalculator\Repositories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Factories\DataSourceAdapterFactory;
use CommissionCalculator\Models\Transaction;

class TransactionRepository
{
    private $dataSourceAdapter;

    /**
     * TransactionRepository constructor.
     *
     * @param string $sourcePath Path to the data source.
     */
    public function __construct(string $sourcePath)
    {
        $this->dataSourceAdapter = (new DataSourceAdapterFactory())->create($sourcePath);
    }

    /**
     * Gets all transactions from the data source and converts them to Transaction objects.
     *
     * @return Transaction[]
     */
    public function getAllTransactions(): array
    {
        return array_map(function ($data) {
            return new Transaction(
                $data['date'],
                $data['userId'],
                $data['userType'],
                $data['transactionType'],
                (float) $data['amount'],
                SupportedCurrencies::tryFrom($data['currency']),
                0.0
            );
        }, $this->dataSourceAdapter->fetchTransactions());
    }
}
