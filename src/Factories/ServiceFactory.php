<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Repositories\TransactionRepository;
use CommissionCalculator\Services\ApiExchangeRateService;
use CommissionCalculator\Services\FixedExchangeRateService;
use CommissionCalculator\Validators\AttributeValidator;

/**
 * ServiceFactory is responsible for creating and configuring various services used by the application.
 * It provides methods to instantiate services like exchange rate services, withdrawal repositories,
 * transaction repositories, and calculator factories based on the provided configuration.
 *
 * Methods:
 * - `createExchangeRateService(): ExchangeRateServiceAbstract`
 *   Creates and configures the exchange rate service, either fixed or API-based.
 *
 * - `createWithdrawalsRepository(): WithdrawalsRepositoryInterface`
 *   Creates and configures the repository for handling withdrawals.
 *
 * - `createTransactionRepository(string $sourcePath): TransactionRepository`
 *   Creates and configures the transaction repository.
 *
 * - `createCalculatorFactory(): CalculatorFactory`
 *   Creates and configures the calculator factory.
 *
 * - `createTransactionValidator(): AttributeValidator`
 *   Creates and returns an instance of the attribute validator.
 *
 * Example:
 * ```
 * $factory = new ServiceFactory($config);
 * $exchangeRateService = $factory->createExchangeRateService();
 * $transactionRepository = $factory->createTransactionRepository('path/to/source.csv');
 * ```
 *
 * @package CommissionCalculator\Factories
 */
class ServiceFactory
{
    /**
     * ServiceFactory constructor.
     *
     * @param array $config Configuration array.
     */
    public function __construct(public array $config)
    {
    }

    /**
     * Creates and configures the exchange rate service.
     *
     * @return ExchangeRateServiceAbstract The exchange rate service instance.
     */
    public function createExchangeRateService(): ExchangeRateServiceAbstract
    {
        $ratesKey = 'exchange_rates';
        $config = $this->config;

        if ($config[$ratesKey]['use_fixed']) {
            return new FixedExchangeRateService($config[$ratesKey]['fixed_rates'], SupportedCurrencies::EUR);
        } else {
            return new ApiExchangeRateService(
                $config[$ratesKey]['api_url'],
                $config[$ratesKey]['api_key'],
                $config[$ratesKey]['base_currency']
            );
        }
    }

    /**
     * Creates and returns a new instance of the WithdrawalsRepositoryInterface based on the configuration.
     *
     * @return WithdrawalsRepositoryInterface The withdrawals repository instance.
     */
    public function createWithdrawalsRepository(): WithdrawalsRepositoryInterface
    {
        return new $this->config['WithdrawalsRepository']();
    }

    /**
     * Creates and configures the transaction repository.
     *
     * @param string $sourcePath Path to the data source.
     * @return TransactionRepository The transaction repository instance.
     */
    public function createTransactionRepository(string $sourcePath): TransactionRepository
    {
        $dataSourceAdapter = (new DataSourceAdapterFactory())->create($sourcePath);
        $validator = $this->createTransactionValidator();
        return new $this->config['TransactionRepository']($dataSourceAdapter, $validator);
    }

    /**
     * Creates and configures the calculator factory.
     *
     * @return CalculatorFactory The calculator factory instance.
     */
    public function createCalculatorFactory(): CalculatorFactory
    {
        $exchangeRateService = $this->createExchangeRateService();
        $withdrawalsRepository = $this->createWithdrawalsRepository();
        return new CalculatorFactory($exchangeRateService, $withdrawalsRepository);
    }

    /**
     * Creates and returns an instance of the AttributeValidator.
     *
     * @return AttributeValidator The attribute validator instance.
     */
    private function createTransactionValidator(): AttributeValidator
    {
        return new AttributeValidator();
    }
}
