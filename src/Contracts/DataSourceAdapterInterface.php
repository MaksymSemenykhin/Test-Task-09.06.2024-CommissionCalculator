<?php

namespace CommissionCalculator\Contracts;

/**
 * interface for subsequent implementations of transaction data sources using inheritance
 * @package CommissionCalculator\Contracts
 */
interface DataSourceAdapterInterface
{
    /**
     * Fetches transactions from the data source.
     *
     * @return array
     */
    public function fetchTransactions(): array;
}
