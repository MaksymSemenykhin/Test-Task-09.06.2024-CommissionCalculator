<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\ValidatorInterface;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Enums\SupportedCurrencies;
use CommissionCalculator\Repositories\TransactionRepository;
use CommissionCalculator\Services\ApiExchangeRateService;
use CommissionCalculator\Services\FixedExchangeRateService;
use CommissionCalculator\Validators\TransactionValidator;

/**
 * ServiceFactory is a class that responsible for creating and configuring various services used by the application.
 * The ServiceFactory class has several methods for creating different services:
 *
 * createExchangeRateService():
 * This method creates and configures the ExchangeRateService.
 * It determines whether to use a fixed exchange rate or an API-based exchange rate.
 *
 * createWithdrawalsRepository():
 * This method creates and configures the class to handle WithdrawalsRepository defined in configuration
 * * createTransactionRepository(string $sourcePath):
 * This method creates and configures the TransactionRepository defined in configuration.
 *
 * createCalculatorFactory():
 * This method creates and configures the CalculatorFactory and supplies ExchangeRateService and WithdrawalsRepository
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
     * Creates and configures the ExchangeRateService.
     *
     * @return ExchangeRateServiceAbstract
     */
    public function createExchangeRateService(): ExchangeRateServiceAbstract
    {
        $ratesK = 'exchange_rates';
        $config = $this->config;
        if ($config[$ratesK]['use_fixed']) {
            return new FixedExchangeRateService($config[$ratesK]['fixed_rates'], SupportedCurrencies::EUR);
        } else {
            return new ApiExchangeRateService(
                $config[$ratesK]['api_url'],
                $config[$ratesK]['api_key'],
                $config[$ratesK]['base_currency']
            );
        }
    }
    /**
     * Creates and returns a new instance of the WithdrawalsRepositoryInterface class based on the configuration.
     *
     * @return WithdrawalsRepositoryInterface The newly created instance of the WithdrawalsRepositoryInterface class.
     */
    public function createWithdrawalsRepository(): WithdrawalsRepositoryInterface
    {
        return new $this->config['WithdrawalsRepository']();
    }
    /**
     * Creates and configures the TransactionRepository.
     *
     * @param string $sourcePath Path to the data source.
     * @return TransactionRepository
     */
    public function createTransactionRepository(string $sourcePath): TransactionRepository
    {
        $dataSourceAdapter = (new DataSourceAdapterFactory())->create($sourcePath);
        $validator = $this->createTransactionValidator();
        return new $this->config['TransactionRepository']($dataSourceAdapter,$validator);
    }

    /**
     * Creates and configures the CalculatorFactory.
     *
     * @return CalculatorFactory
     */
    public function createCalculatorFactory(): CalculatorFactory
    {
        $exchangeRateService = $this->createExchangeRateService();
        $withdrawalsRepository = $this->createWithdrawalsRepository();
        return new CalculatorFactory($exchangeRateService, $withdrawalsRepository);
    }

    /**
     * Creates and returns a new instance of the TransactionValidator class, which implements the ValidatorInterface.
     *
     * @return ValidatorInterface The newly created TransactionValidator instance.
     */
    private function createTransactionValidator(): ValidatorInterface
    {
        return new TransactionValidator();
    }
}
