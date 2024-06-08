<?php

namespace CommissionCalculator\Enums;

enum OutputType: string
{
    case Console = 'console';
    case Txt = 'txt';
    case Xml = 'xml';
}
