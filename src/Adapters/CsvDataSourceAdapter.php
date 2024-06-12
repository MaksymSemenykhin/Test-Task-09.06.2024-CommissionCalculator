<?php

namespace CommissionCalculator\Adapters;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;

/**
 * CsvDataSourceAdapter is a class that functionality to fetch transactions from a CSV file.
 * It responsible for reading transactions from a CSV file and converting them into an array of associative arrays.
 * Part of the `DataSourceAdapterInterface` which allows use different data sources.
 *
 * The `CsvDataSourceAdapter` class has a constructor that takes a single parameter,
 * `filePath`, which is the path to the CSV file.
 *
 * @package CommissionCalculator\Adapters
 */
readonly class CsvDataSourceAdapter implements DataSourceAdapterInterface
{
    /**
     * CsvDataSourceAdapter constructor.
     *
     * @param string $filePath Path to the CSV file.
     * @param array $supportedFields
     */
    public function __construct(private string $filePath, private array $supportedFields)
    {
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
            if ($row && count($row) == sizeof($this->supportedFields)) {
                return array_combine($this->supportedFields, $row);
            }
        }, $rows);
    }
}
