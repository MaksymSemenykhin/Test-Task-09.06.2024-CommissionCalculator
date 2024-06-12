<?php

namespace CommissionCalculator\Enums;

/**
 * The KnownConfigs enum is used to define supported config files
 * Used to avoid typos in the title of the config files
 *
 * @package CommissionCalculator\Enums
 */
enum KnownConfigs: string
{
    case Local = 'config.local.php';
    case Main = 'config.php';
    case Tests = 'config.tests.php';
}
