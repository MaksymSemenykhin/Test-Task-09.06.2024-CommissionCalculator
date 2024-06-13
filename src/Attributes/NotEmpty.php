<?php

namespace CommissionCalculator\Attributes;

use Attribute;

/**
 * The NotEmpty attribute is used to indicate that a property must not be empty.
 * When applied, it ensures that the property's value is checked to be non-empty.
 * This attribute can be used on properties of any data type.
 *
 * Example:
 * ```
 * #[NotEmpty]
 * public string $date;
 * ```
 *
 * Usage:
 * - Apply this attribute to properties that must have a non-empty value.
 * - Works with strings, arrays, and other types that can be checked for emptiness.
 *
 * @package CommissionCalculator\Attributes
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class NotEmpty
{
}
