<?php

use CommissionCalculator\Enums\EnvironmentType;
use CommissionCalculator\Enums\OutputType;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Repositories\TransactionRepository;
use CommissionCalculator\Repositories\WithdrawalsRepository;

return [
    'WithdrawalsRepository'=> WithdrawalsRepository::class,
    'TransactionRepository'=> TransactionRepository::class,
    'environment' => EnvironmentType::Production,
    'data_source' => [
        'type' => 'csv',
        'path' => './tests/input.csv', // Default path
    ],
    'exchange_rates' => [
        'api_url' => 'https://api.apilayer.com/exchangerates_data/latest',
        'api_key' => getenv('API_KEY'),
        'use_fixed' => false, // Toggle between fixed rates and API
        'base_currency' => SupportedCurrencies::EUR,
    ],
    'output' => [
        'type' => OutputType::Console,
        'file_path' => 'output/', // Used only for 'txt' and 'xml'
        'file_name' => 'results.txt', // Used only for 'txt' and 'xml'
    ],
];
