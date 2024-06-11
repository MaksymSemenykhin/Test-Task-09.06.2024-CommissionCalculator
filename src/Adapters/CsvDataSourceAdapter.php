<?php

namespace CommissionCalculator\Adapters;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;

class CsvDataSourceAdapter implements DataSourceAdapterInterface
{
    private string $filePath;

    /**
     * CsvDataSourceAdapter constructor.
     *
     * @param string $filePath Path to the CSV file.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Fetches transactions from a CSV file.
     *
     * @return array
     */
    public function fetchTransactions(): array
    {
        $rows = array_map('str_getcsv', file($this->filePath));
        return array_map(function ($row) {
            if ($row && count($row) == 6) {
                return array_combine(['date', 'userId', 'userType', 'transactionType', 'amount', 'currency'], $row);
            }
        }, $rows);
    }
}
