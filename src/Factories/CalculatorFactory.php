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

class CalculatorFactory
{
    private ExchangeRateServiceAbstract $exchangeRateService;
    private WithdrawalsRepositoryInterface $withdrawalsRepository;

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
     * @param S_O $transactionType The transaction type.
     * @param C_T $userType The user type.
     * @return CommissionStrategyAbstract
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
            default => throw new \InvalidArgumentException(
                "Unsupported transaction or user type: $transactionType->value, $userType->value"
            ),
        };
    }
}
