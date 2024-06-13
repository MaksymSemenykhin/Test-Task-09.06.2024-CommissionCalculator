<?php

namespace CommissionCalculator\Strategies;

use CommissionCalculator\Contracts\CommissionStrategyStraightCommission;

/**
 * DepositStrategy calculates the commission for deposit transactions.
 * This strategy extends `CommissionStrategyStraightCommission` and applies a fixed commission rate
 * for deposit operations.
 *
 * Properties:
 * - `float COMMISSION_RATE` — The fixed commission rate for deposits (0.03%).
 *
 * Example:
 * ```
 * $strategy = new DepositStrategy();
 * $commission = $strategy->calculate($transaction);
 * ```
 *
 * @package CommissionCalculator\Strategies
 */
class DepositStrategy extends CommissionStrategyStraightCommission
{
    final protected const COMMISSION_RATE = 0.0003; // 0.03%
}
