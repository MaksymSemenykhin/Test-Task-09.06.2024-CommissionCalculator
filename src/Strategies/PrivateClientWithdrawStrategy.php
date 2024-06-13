<?php

namespace CommissionCalculator\Strategies;

use CommissionCalculator\Abstracts\CommissionStrategyAbstract;
use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use CommissionCalculator\Models\Transaction;

/**
 * PrivateClientWithdrawStrategy calculates the commission for private client withdrawals.
 * This strategy extends `CommissionStrategyAbstract` and applies a commission rate for withdrawals,
 * taking into account a weekly free limit and the number of free withdrawals allowed per week.
 *
 * Properties:
 * - `float COMMISSION_RATE` — The fixed commission rate for private client withdrawals (0.3%).
 * - `float FREE_LIMIT` — The weekly limit of free withdrawals (1000.00 EUR).
 * - `int MAX_FREE_WITHDRAWALS` — The maximum number of free withdrawals allowed per week (3).
 *
 * Methods:
 * - `__construct(
 * ExchangeRateServiceAbstract $exchangeRateService,
 * WithdrawalsRepositoryInterface $withdrawalsRepository)`
 *   Initializes the strategy with the exchange rate service and withdrawals repository.
 *
 * - `calculateChargeableAmount(Transaction $transaction): float`
 *   Calculates the chargeable amount for the transaction, considering the weekly free limit and number of withdrawals.
 *
 * Example:
 * ```
 * $exchangeRateService = new ApiExchangeRateService('https://api.exchangeratesapi.io/latest', 'your_api_key');
 * $withdrawalsRepository = new WithdrawalsRepository();
 * $strategy = new PrivateClientWithdrawStrategy($exchangeRateService, $withdrawalsRepository);
 * $commission = $strategy->calculate($transaction);
 * ```
 *
 * @package CommissionCalculator\Strategies
 */
class PrivateClientWithdrawStrategy extends CommissionStrategyAbstract
{
    protected const COMMISSION_RATE = 0.003; // 0.3%
    private const FREE_LIMIT = 1000.00;
    private const MAX_FREE_WITHDRAWALS = 3;

    public function __construct(
        protected ExchangeRateServiceAbstract $exchangeRateService,
        private readonly WithdrawalsRepositoryInterface $withdrawalsRepository
    ) {
    }
    /**
     * Calculates the chargeable amount for the transaction, considering the weekly free limit and count of withdrawals.
     *
     * @param Transaction $transaction The transaction object.
     * @return float The chargeable amount for the transaction.
     * @throws \Exception If there is an error during calculation.
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
