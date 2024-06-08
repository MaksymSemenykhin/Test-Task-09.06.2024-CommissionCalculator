<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Contracts\CommissionStrategyAbstract;
use CommissionCalculator\Contracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Repositories\WithdrawalsRepository;
use CommissionCalculator\Strategies\PrivateClientWithdrawStrategy;
use CommissionCalculator\Strategies\BusinessClientWithdrawStrategy;
use CommissionCalculator\Strategies\DepositStrategy;

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
     * @param string $transactionType The transaction type.
     * @param string $userType The user type.
     * @return CommissionStrategyAbstract
     */
    public function create(string $transactionType, string $userType): CommissionStrategyAbstract
    {
        return match ([$transactionType, $userType]) {
            ['deposit', 'private'], ['deposit', 'business'] => new DepositStrategy($this->exchangeRateService),
            ['withdraw', 'private'] => new PrivateClientWithdrawStrategy(
                $this->exchangeRateService,
                $this->withdrawalsRepository
            ),
            ['withdraw', 'business'] => new BusinessClientWithdrawStrategy($this->exchangeRateService),
            default => throw new \InvalidArgumentException(
                "Unsupported transaction or user type: $transactionType, $userType"
            ),
        };
    }
}
