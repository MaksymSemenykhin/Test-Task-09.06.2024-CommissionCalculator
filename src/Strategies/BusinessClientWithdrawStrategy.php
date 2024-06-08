<?php

namespace CommissionCalculator\Strategies;

use CommissionCalculator\Contracts\CommissionStrategyStraightCommission;

class BusinessClientWithdrawStrategy extends CommissionStrategyStraightCommission
{
    final protected const COMMISSION_RATE = 0.005; // 0.5%
}
