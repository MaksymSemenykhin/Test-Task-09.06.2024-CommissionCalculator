<?php

namespace CommissionCalculator\Strategies;

use CommissionCalculator\Contracts\CommissionStrategyStraightCommission;

/**
 * BusinessClientWithdrawStrategy calculates the commission for business client withdrawals.
 * This strategy extends `CommissionStrategyStraightCommission` and applies a fixed commission rate
 * for withdrawals made by business clients.
 *
 * Properties:
 * - `float COMMISSION_RATE` — The fixed commission rate for business client withdrawals (0.5%).
 *
 * Example:
 * ```
 * $strategy = new BusinessClientWithdrawStrategy();
 * $commission = $strategy->calculate($transaction);
 * ```
 *
 * @package CommissionCalculator\Strategies
 */
class BusinessClientWithdrawStrategy extends CommissionStrategyStraightCommission
{
    final protected const COMMISSION_RATE = 0.005; // 0.5%
}
