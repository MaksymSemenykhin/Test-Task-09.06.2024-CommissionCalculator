<?php

namespace CommissionCalculator\Repositories;

use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use DateTime;

class WithdrawalsRepository implements WithdrawalsRepositoryInterface
{
    private array $withdrawals = [];
    private array $operations = [];
    public function getWeeklyOperationCount(int $userId, DateTime $weekStart): int
    {
        $weekKey = $this->getWeekKey($userId, $weekStart);
        if (!isset($this->operations[$weekKey])) {
            $this->operations[$weekKey] = 0;
        }

        return $this->operations[$weekKey];
    }

    public function getTotalWithdrawn(int $userId, DateTime $weekStart): float
    {
        $weekKey = $this->getWeekKey($userId, $weekStart);
        return  $this->withdrawals[$weekKey] ?? 0.0;
    }

    public function addWithdrawnAmount(int $userId, DateTime $weekStart, float $amount): void
    {
        $weekKey = $this->getWeekKey($userId, $weekStart);
        if (!isset($this->withdrawals[$weekKey])) {
            $this->withdrawals[$weekKey] = 0.0;
        }
        $this->withdrawals[$weekKey] += $amount;
        $this->operations[$weekKey]++;
    }

    private function getWeekKey(int $userId, DateTime $weekStart): string
    {
        return $userId . '-' . $weekStart->format('oW');
    }
}
