<?php

use CommissionCalculator\Enums\EnvironmentType;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Repositories\TransactionRepository;
use CommissionCalculator\Repositories\WithdrawalsRepository;

return [
    'WithdrawalsRepository'=> WithdrawalsRepository::class,
    'TransactionRepository'=> TransactionRepository::class,

    'environment' => EnvironmentType::Testing,
    'data_source' => [
        'type' => 'csv',
        'path' => './tests/input.csv', // Default path
    ],
    'exchange_rates' => [
        'fixed_rates' => [
            'EUR' => 1,
            'USD' => 1.1497,
            'JPY' => 129.53,
        ],
        'base_currency' => SupportedCurrencies::EUR,
        'use_fixed' => true, // Toggle between fixed rates and API
    ]
];
