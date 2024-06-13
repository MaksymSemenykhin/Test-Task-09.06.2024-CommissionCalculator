<?php

namespace CommissionCalculator\Attributes;

use Attribute;

/**
 * The EnumValue attribute is used to validate that a property's value must be one of the values defined
 * in a specific enum. When applied, it ensures that the property's value matches one of the
 * valid values from the specified enum class.
 *
 * Example:
 * ```
 * #[EnumValue(enumClass: UserType::class)]
 * public string $userType;
 * ```
 *
 * Usage:
 * - Apply this attribute to properties that must have a value defined by a specific enum.
 * - Ensures that the property's value is constrained to valid enum values, improving type safety.
 *
 * @package CommissionCalculator\Attributes
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class EnumValue
{
    public function __construct(
        private string $enumClass
    ) {
    }

    public function getEnumClass(): string
    {
        return $this->enumClass;
    }
}
