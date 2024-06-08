<?php

namespace CommissionCalculator\Strategies;

use CommissionCalculator\Contracts\CommissionStrategyStraightCommission;

class DepositStrategy extends CommissionStrategyStraightCommission
{
    final protected const COMMISSION_RATE = 0.0003; // 0.03%
}
