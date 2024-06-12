<?php

namespace CommissionCalculator\Enums;

/**
 * The OutputType enum is used to define supported OutputType services
 * Used to avoid typos in the title of the config files
 *
 * @package CommissionCalculator\Enums
 */
enum OutputType: string
{
    case Console = 'console';
    case Txt = 'txt';
    case Xml = 'xml';
    case Array = 'array';
}
