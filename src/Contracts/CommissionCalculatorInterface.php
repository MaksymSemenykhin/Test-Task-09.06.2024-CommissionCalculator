<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Models\Transaction;

interface CommissionCalculatorInterface
{
    public function calculate(Transaction $operation): float;
}
