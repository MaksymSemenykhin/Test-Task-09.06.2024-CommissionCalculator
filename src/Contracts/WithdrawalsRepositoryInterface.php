<?php

namespace CommissionCalculator\Contracts;

use DateTime;

interface WithdrawalsRepositoryInterface
{
    /**
     * Gets the total amount withdrawn by the user for a given week.
     *
     * @param int $userId The user's ID.
     * @param DateTime $weekStart The start of the week.
     * @return float The total amount withdrawn.
     */
    public function getTotalWithdrawn(int $userId, DateTime $weekStart): float;

    /**
     * Adds a withdrawn amount to the user's total for a given week.
     *
     * @param int $userId The user's ID.
     * @param DateTime $weekStart The start of the week.
     * @param float $amount The amount withdrawn.
     */
    public function addWithdrawnAmount(int $userId, DateTime $weekStart, float $amount): void;

    public function getWeeklyOperationCount(int $userId, DateTime $weekStart): int;
}
