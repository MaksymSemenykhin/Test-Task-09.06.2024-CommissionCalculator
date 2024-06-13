<?php

namespace CommissionCalculator\Repositories;

use CommissionCalculator\Contracts\WithdrawalsRepositoryInterface;
use DateTime;

/**
 * WithdrawalsRepository manages the tracking of withdrawal operations and amounts
 * for individual users on a weekly basis. This repository stores and retrieves
 * information about the number of operations and total amounts withdrawn per user
 * for a given week.
 *
 * Methods:
 * - `getWeeklyOperationCount(int $userId, DateTime $weekStart): int`
 *   Returns the number of withdrawal operations a user has performed in a given week.
 *
 * - `getTotalWithdrawn(int $userId, DateTime $weekStart): float`
 *   Returns the total amount withdrawn by a user in a given week.
 *
 * - `addWithdrawnAmount(int $userId, DateTime $weekStart, float $amount): void`
 *   Adds a withdrawal amount to the user's record for the given week and increments the operation count.
 *
 * - `getWeekKey(int $userId, DateTime $weekStart): string`
 *   Generates a unique key for tracking weekly data based on user ID and week start date.
 *
 * Example:
 * ```
 * $repository = new WithdrawalsRepository();
 * $weekStart = new DateTime('2024-01-01');
 * $repository->addWithdrawnAmount(1, $weekStart, 100.0);
 * $operationCount = $repository->getWeeklyOperationCount(1, $weekStart);
 * $totalWithdrawn = $repository->getTotalWithdrawn(1, $weekStart);
 * ```
 *
 * @package CommissionCalculator\Repositories
 */
class WithdrawalsRepository implements WithdrawalsRepositoryInterface
{
    private array $withdrawals = [];
    private array $operations = [];

    /**
     * Returns the number of withdrawal operations a user has performed in a given week.
     *
     * @param int $userId The user's unique identifier.
     * @param DateTime $weekStart The start date of the week.
     * @return int The number of withdrawal operations.
     */
    public function getWeeklyOperationCount(int $userId, DateTime $weekStart): int
    {
        $weekKey = $this->getWeekKey($userId, $weekStart);
        if (!isset($this->operations[$weekKey])) {
            $this->operations[$weekKey] = 0;
        }

        return $this->operations[$weekKey];
    }

    /**
     * Returns the total amount withdrawn by a user in a given week.
     *
     * @param int $userId The user's unique identifier.
     * @param DateTime $weekStart The start date of the week.
     * @return float The total amount withdrawn.
     */
    public function getTotalWithdrawn(int $userId, DateTime $weekStart): float
    {
        $weekKey = $this->getWeekKey($userId, $weekStart);
        return $this->withdrawals[$weekKey] ?? 0.0;
    }

    /**
     * Adds a withdrawal amount to the user's record for the given week and increments the operation count.
     *
     * @param int $userId The user's unique identifier.
     * @param DateTime $weekStart The start date of the week.
     * @param float $amount The amount withdrawn.
     */
    public function addWithdrawnAmount(int $userId, DateTime $weekStart, float $amount): void
    {
        $weekKey = $this->getWeekKey($userId, $weekStart);
        if (!isset($this->withdrawals[$weekKey])) {
            $this->withdrawals[$weekKey] = 0.0;
        }
        $this->withdrawals[$weekKey] += $amount;
        $this->operations[$weekKey]++;
    }

    /**
     * Generates a unique key for tracking weekly data based on user ID and week start date.
     *
     * @param int $userId The user's unique identifier.
     * @param DateTime $weekStart The start date of the week.
     * @return string The unique key for tracking weekly data.
     */
    private function getWeekKey(int $userId, DateTime $weekStart): string
    {
        return $userId . '-' . $weekStart->format('oW');
    }
}
