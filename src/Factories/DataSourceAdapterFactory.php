<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Contracts\DataSourceAdapterInterface;
use CommissionCalculator\Adapters\CsvDataSourceAdapter;

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

        switch ($extension) {
            case 'csv':
                return new CsvDataSourceAdapter($sourcePath);
                // You can add more cases here for different types of data sources.
            default:
                throw new \InvalidArgumentException("Unsupported data source type: $extension");
        }
    }
}
