[![CI/CD Pipeline](https://github.com/MaksymSemenykhin/Test-Task-09.06.2024-CommissionCalculator/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/MaksymSemenykhin/Test-Task-09.06.2024-CommissionCalculator/actions/workflows/ci.yml)

# Commission Calculator
## Description 
This project is a test assignment created on June 9, 2024, to demonstrate skills in programming and code organization in PHP that took 25h+ time.
This application([task](./task.md)) calculates commissions for deposit and withdrawal operations based on predefined rules. Commissions are calculated for private and business clients, taking into account currencies and weekly limits.

The application supports the following operations:
- **Deposits**: Fixed rate of 0.03%.
- **Withdrawals for private clients**: Rate of 0.3% with a weekly free limit of 1000.00 EUR and up to 3 free operations per week.
- **Withdrawals for business clients**: Fixed rate of 0.5%.

Commissions are rounded up to the appropriate decimal places for each currency.

## Installation

1. Clone the repository:
```bash
   git clone https://github.com/MaksymSemenykhin/Test-Task-09.06.2024-CommissionCalculator.git
   cd Test-Task-09.06.2024-CommissionCalculator
```
2. Install dependencies using Composer:
```bash
   composer install
```

3. Place api.apilayer.com api key in config/config.local.php or config/config.php file   

## Requirements

- **PHP**: Version 8.3 or higher.
- **Composer**: For dependency management.
- **GuzzleHTTP**: For making HTTP requests (installed via Composer).
- **PHPUnit**: For running tests (installed via Composer).

## Running the Application

To calculate commissions, use the command:
```bash
php index.php input.csv
```
    
Where input.csv is a CSV file with operations. Example content of input.csv:
```bash
    2014-12-31,4,private,withdraw,1200.00,EUR
    2015-01-01,4,private,withdraw,1000.00,EUR
    2016-01-05,4,private,withdraw,1000.00,EUR 
    2016-01-05,1,private,deposit,200.00,EUR
```

## Configuration
### Configuration Files
1. config/config.php: Basic configuration.
2. config/config.local.php: Priority env configuration.
3. config/testing.php: Configuration for the testing environment.
([Folder structure](./structure.md))

### Configuration Example
```php
Example configuration file (config/production.php):
return [
    'environment' => 'production',
    'api_url' => 'https://api.apilayer.com/exchangerates_data/latest',
    'api_key' => getenv('API_KEY') ?: 'your_api_key',
    'exchange_rates' => [
            'use_fixed' => false,
            'fixed_rates' => [
            'USD' => 1.1497,
            'JPY' => 129.53,
        ],
    ],
    'TransactionRepository' => \CommissionCalculator\Repositories\TransactionRepository::class,
    'WithdrawalsRepository' => \CommissionCalculator\Repositories\WithdrawalsRepository::class,
];
```

## Running Tests
### To run all tests:

```bash
vendor/bin/phpunit tests
```
