<?php

namespace CommissionCalculator\Strategies;

use CommissionCalculator\Contracts\CommissionStrategyAbstract;
use CommissionCalculator\Contracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Models\Transaction;

class PrivateClientWithdrawStrategy extends CommissionStrategyAbstract
{
    private WithdrawalsRepositoryInterface $withdrawalsRepository;
    protected const COMMISSION_RATE = 0.003; // 0.3%
    private const FREE_LIMIT = 1000.00;
    private const MAX_FREE_WITHDRAWALS = 3;

    private array $weeklyWithdrawals = [];
    private array $weeklyOperations = [];

    public function __construct(
        ExchangeRateServiceAbstract $exchangeRateService,
        WithdrawalsRepositoryInterface $withdrawalsRepository
    ) {
        $this->exchangeRateService = $exchangeRateService;
        $this->withdrawalsRepository = $withdrawalsRepository;
    }

    /**
     * @throws \Exception
     */
    protected function calculateChargeableAmount(Transaction $transaction): float
    {
        $date = new \DateTime($transaction->date);

        $totalWithdrawn = $this->withdrawalsRepository->getTotalWithdrawn($transaction->userId, $date);
        $totalOperationsCount = $this->withdrawalsRepository->getWeeklyOperationCount($transaction->userId, $date);

        if ($totalWithdrawn < self::FREE_LIMIT && $totalOperationsCount < self::MAX_FREE_WITHDRAWALS) {
            $chargeableAmount = max(0, $transaction->amountInEUR - (self::FREE_LIMIT - $totalWithdrawn));
        } else {
            $chargeableAmount = $transaction->amountInEUR;
        }
        $chargeableAmount *= static::COMMISSION_RATE;
        $this->withdrawalsRepository->addWithdrawnAmount($transaction->userId, $date, $transaction->amountInEUR);

        return $chargeableAmount;
    }
}
