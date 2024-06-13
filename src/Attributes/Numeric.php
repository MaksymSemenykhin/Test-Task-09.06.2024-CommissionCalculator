<?php

namespace CommissionCalculator\Attributes;

use Attribute;

/**
 * The Numeric attribute is used to indicate that a property must be numeric.
 * When applied, it ensures that the property's value is a numeric type, either integer or float.
 *
 * Example:
 * ```
 * #[Numeric]
 * public float $amount;
 * ```
 *
 * Usage:
 * - Apply this attribute to properties that must hold numeric values.
 * - Ensures type consistency and prevents non-numeric values in numeric fields.
 *
 * @package CommissionCalculator\Attributes
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Numeric
{
}
