<?php

namespace CommissionCalculator\Calculators;

use CommissionCalculator\Abstracts\ExchangeRateServiceAbstract;
use CommissionCalculator\Contracts\CommissionCalculatorInterface;
use CommissionCalculator\Models\Transaction;

class WithdrawCalculator implements CommissionCalculatorInterface
{
    private $exchangeRateService;
    private $userWithdrawals = [];

    /**
     * WithdrawCalculator constructor.
     *
     * @param ExchangeRateServiceAbstract $exchangeRateService Exchange rate service.
     */
    public function __construct(ExchangeRateServiceAbstract $exchangeRateService)
    {
        $this->exchangeRateService = $exchangeRateService;
    }

    /**
     * Calculates commission for a withdraw transaction.
     *
     * @param array $transaction Transaction data.
     * @return float
     */
    public function calculate(Transaction $transaction): float
    {
        $date = $transaction->date;
        $userId = $transaction->userId;
        $userType = $transaction->userType;
        $amount = (float) $transaction->amount;
        $currency = $transaction->currency;

        return $userType === 'private' ?
            $this->calculatePrivateWithdrawCommission($date, $userId, $amount, $currency) :
            $this->calculateBusinessWithdrawCommission($amount, $currency);
    }

    /**
     * Calculates commission for a private client's withdraw transaction.
     *
     * @param string $date Transaction date.
     * @param string $userId User ID.
     * @param float $amount Amount.
     * @param string $currency Currency code.
     * @return float
     */
    private function calculatePrivateWithdrawCommission(
        string $date,
        string $userId,
        float $amount,
        string $currency
    ): float {
        $amountInEUR = $currency === 'EUR' ? $amount : $this->exchangeRateService->convertToEUR($amount, $currency);
        $weekKey = $this->getWeekKey($date);

        if (!isset($this->userWithdrawals[$userId][$weekKey])) {
            $this->userWithdrawals[$userId][$weekKey] = [
                'freeAmount' => 1000,
                'withdrawals' => 0,
            ];
        }

        if ($this->userWithdrawals[$userId][$weekKey]['withdrawals'] < 3) {
            if ($amountInEUR <= $this->userWithdrawals[$userId][$weekKey]['freeAmount']) {
                $this->userWithdrawals[$userId][$weekKey]['freeAmount'] -= $amountInEUR;
                $this->userWithdrawals[$userId][$weekKey]['withdrawals']++;
                return 0;
            } else {
                $commissionableAmount = $amountInEUR - $this->userWithdrawals[$userId][$weekKey]['freeAmount'];
                $this->userWithdrawals[$userId][$weekKey]['freeAmount'] = 0;
                $this->userWithdrawals[$userId][$weekKey]['withdrawals']++;
                return $this->roundUp($commissionableAmount * 0.003, $currency);
            }
        }

        return $this->roundUp($amountInEUR * 0.003, $currency);
    }

    /**
     * Calculates commission for a business client's withdraw transaction.
     *
     * @param float $amount Amount.
     * @param string $currency Currency code.
     * @return float
     */
    private function calculateBusinessWithdrawCommission(float $amount, string $currency): float
    {
        return $this->roundUp($amount * 0.005, $currency);
    }

    /**
     * Rounds up the amount to the currency's decimal places.
     *
     * @param float $amount Amount to round.
     * @param string $currency Currency code.
     * @return float
     */
    private function roundUp(float $amount, string $currency): float
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        return ceil($amount * pow(10, $decimalPlaces)) / pow(10, $decimalPlaces);
    }

    /**
     * Gets the number of decimal places for a currency.
     *
     * @param string $currency Currency code.
     * @return int
     */
    private function getDecimalPlaces(string $currency): int
    {
        return $currency === 'JPY' ? 0 : 2;
    }

    /**
     * Gets the week key for a date.
     *
     * @param string $date Date.
     * @return string
     */
    private function getWeekKey(string $date): string
    {
        $dateTime = new \DateTime($date);
        $year = $dateTime->format('o'); // ISO-8601 year number
        $week = $dateTime->format('W'); // ISO-8601 week number

        return $year . '-' . $week;
    }
}
