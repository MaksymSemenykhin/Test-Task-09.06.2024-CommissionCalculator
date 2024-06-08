<?php

namespace CommissionCalculator\Contracts;

interface DataSourceAdapterInterface
{
    /**
     * Fetches transactions from the data source.
     *
     * @return array
     */
    public function fetchTransactions(): array;
}
