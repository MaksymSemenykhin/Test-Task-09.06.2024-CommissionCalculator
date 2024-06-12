<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Abstracts\CommissionStrategyAbstract;
use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Enums\ClientsTypes;
use CommissionCalculator\Enums\SupportedOperations;
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
     * @param SupportedOperations $transactionType The transaction type.
     * @param ClientsTypes $userType The user type.
     * @return CommissionStrategyAbstract
     */
    public function create(SupportedOperations $transactionType, ClientsTypes $userType): CommissionStrategyAbstract
    {
        return match ([$transactionType, $userType]) {
            [SupportedOperations::DEPOSIT,ClientsTypes::PRIVATE],
            [SupportedOperations::DEPOSIT, ClientsTypes::BUSINESS] => new DepositStrategy($this->exchangeRateService),
            [SupportedOperations::WITHDRAW, ClientsTypes::PRIVATE] => new PrivateClientWithdrawStrategy(
                $this->exchangeRateService,
                $this->withdrawalsRepository
            ),
            [SupportedOperations::WITHDRAW,
                ClientsTypes::BUSINESS] => new BusinessClientWithdrawStrategy($this->exchangeRateService),
            default => throw new \InvalidArgumentException(
                "Unsupported transaction or user type: $transactionType->value, $userType"
            ),
        };
    }
}
