<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Adapters\CsvDataSourceAdapter;
use CommissionCalculator\Models\Transaction;

class DataSourceAdapterFactory
{
    /**
     * Creates a data source adapter based on the source path.
     *
     * @param string $sourcePath Path to the data source.
     * @return DataSourceAdapterInterface
     * @throws \InvalidArgumentException
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
