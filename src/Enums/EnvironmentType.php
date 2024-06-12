<?php

namespace CommissionCalculator\Enums;

/**
 * The EnvironmentType enum is used to define the type of environment that the application is running in.
 * Used to avoid typos in the title of the config files
 *
 * @package CommissionCalculator\Enums
 */
enum EnvironmentType: string
{
    case Production = 'production';
    case Testing = 'tests';
}
