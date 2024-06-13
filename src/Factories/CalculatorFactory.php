<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Abstracts\CommissionStrategyAbstract;
use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Enums\ClientsTypes as C_T;
use CommissionCalculator\Enums\SupportedOperations as S_O;
use CommissionCalculator\Strategies\BusinessClientWithdrawStrategy;
use CommissionCalculator\Strategies\DepositStrategy;
use CommissionCalculator\Strategies\PrivateClientWithdrawStrategy;
use InvalidArgumentException;

/**
 * CalculatorFactory creates instances of commission calculation strategies based on transaction and user types.
 * This factory encapsulates the logic for selecting the appropriate strategy for calculating commission fees
 * depending on the type of transaction (deposit or withdraw) and the type of client (private or business).
 *
 * Properties:
 * - `ExchangeRateServiceAbstract $exchangeRateService` — Service for retrieving exchange rates.
 * - `WithdrawalsRepositoryInterface $withdrawalsRepository` — Repository for tracking withdrawals.
 *
 * Methods:
 * - `__construct(
 * ExchangeRateServiceAbstract $exchangeRateService,
 * WithdrawalsRepositoryInterface $withdrawalsRepository)`
 *   Constructs the factory with the necessary dependencies for creating commission strategies.
 *
 * - `create(S_O $transactionType, C_T $userType): CommissionStrategyAbstract`
 *   Creates the appropriate commission strategy based on the transaction type and user type.
 *
 * Example:
 * ```
 * $factory = new CalculatorFactory($exchangeRateService, $withdrawalsRepository);
 * $strategy = $factory->create(S_O::DEPOSIT, C_T::PRIVATE);
 * ```
 *
 * @package CommissionCalculator\Factories
 */
class CalculatorFactory
{
    private ExchangeRateServiceAbstract $exchangeRateService;
    private WithdrawalsRepositoryInterface $withdrawalsRepository;

    /**
     * CalculatorFactory constructor.
     *
     * @param ExchangeRateServiceAbstract $exchangeRateService Service for retrieving exchange rates.
     * @param WithdrawalsRepositoryInterface $withdrawalsRepository Repository for tracking withdrawals.
     */
    public function __construct(
        ExchangeRateServiceAbstract $exchangeRateService,
        WithdrawalsRepositoryInterface $withdrawalsRepository
    ) {
        $this->exchangeRateService = $exchangeRateService;
        $this->withdrawalsRepository = $withdrawalsRepository;
    }

    /**
     * Creates the appropriate commission strategy based on transaction type.
     *
     * @param S_O $transactionType The transaction type (e.g., deposit, withdraw).
     * @param C_T $userType The user type (e.g., private, business).
     * @return CommissionStrategyAbstract The appropriate strategy for calculating the commission.
     * @throws InvalidArgumentException If the transaction or user type is unsupported.
     */
    public function create(S_O $transactionType, C_T $userType): CommissionStrategyAbstract
    {
        return match ([$transactionType, $userType]) {
            [S_O::DEPOSIT, C_T::PRIVATE],
            [S_O::DEPOSIT, C_T::BUSINESS] => new DepositStrategy($this->exchangeRateService),
            [S_O::WITHDRAW, C_T::PRIVATE] => new PrivateClientWithdrawStrategy(
                $this->exchangeRateService,
                $this->withdrawalsRepository
            ),
            [S_O::WITHDRAW, C_T::BUSINESS] => new BusinessClientWithdrawStrategy($this->exchangeRateService),
            default => throw new InvalidArgumentException(
                "Unsupported transaction or user type: $transactionType->value, $userType->value"
            ),
        };
    }
}
