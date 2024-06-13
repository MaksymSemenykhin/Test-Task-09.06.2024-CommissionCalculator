<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Adapters\CsvDataSourceAdapter;
use CommissionCalculator\Models\Transaction;

/**
 * DataSourceAdapterFactory creates instances of data source adapters based on the provided source path.
 * This factory determines the appropriate adapter to use for reading transaction data from various file formats.
 *
 * Methods:
 * - `create(string $sourcePath): DataSourceAdapterInterface`
 *   Creates a data source adapter based on the file extension of the provided source path.
 *
 * Example:
 * ```
 * $factory = new DataSourceAdapterFactory();
 * $adapter = $factory->create('transactions.csv');
 * $data = $adapter->getData();
 * ```
 *
 * @package CommissionCalculator\Factories
 */
class DataSourceAdapterFactory
{
    /**
     * Creates a data source adapter based on the source path.
     *
     * @param string $sourcePath Path to the data source.
     * @return DataSourceAdapterInterface The appropriate data source adapter for the given source path.
     * @throws \InvalidArgumentException If the data source type is unsupported.
     */
    public function create(string $sourcePath): DataSourceAdapterInterface
    {
        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);

        return match ($extension) {
            'csv' => new CsvDataSourceAdapter($sourcePath, Transaction::$fieldsList),
            default => throw new \InvalidArgumentException("Unsupported data source type: $extension"),
        };
    }
}
