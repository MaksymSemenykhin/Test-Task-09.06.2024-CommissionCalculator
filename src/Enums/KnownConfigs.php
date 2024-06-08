<?php

namespace CommissionCalculator\Enums;

enum KnownConfigs: string
{
    case Local = 'config.local.php';
    case Main = 'config.php';
    case Tests = 'config.tests.php';
}
