<?php

namespace CommissionCalculator\Validators;

use ReflectionClass;
use ReflectionProperty;
use InvalidArgumentException;

/**
 * AttributeValidator validates object properties based on custom validation attributes.
 * This class uses reflection to inspect properties of the given object and apply
 * the validation logic defined by attached attributes. If a property value does not meet
 * the criteria specified by its attributes, an appropriate error message is generated.
 *
 * Methods:
 * - `validate(object $object): array`
 *   Validates the given object and returns a list of validation errors, if any.
 *
 * Example:
 * ```
 * $transaction = new Transaction(...);
 * $validator = new AttributeValidator();
 * $errors = $validator->validate($transaction);
 * if (!empty($errors)) {
 *     // Handle validation errors
 * }
 * ```
 *
 * @package CommissionCalculator\Validators
 */
class AttributeValidator
{
    /**
     * Validates the given object based on its attributes.
     *
     * @param object $object The object to validate.
     * @return array List of validation errors, if any.
     */
    public function validate(object $object): array
    {
        $errors = [];
        $reflectionClass = new ReflectionClass($object);

        foreach ($reflectionClass->getProperties() as $property) {
            $value = $property->getValue($object);
            foreach ($property->getAttributes() as $attribute) {
                $validator = $this->getValidator($attribute->getName());
                $attributeInstance = $attribute->newInstance();
                $validator($value, $attributeInstance, $property, $errors);
            }
        }

        return $errors;
    }

    /**
     * Retrieves the appropriate validator function for the given attribute.
     *
     * @param string $attributeName The name of the attribute.
     * @return callable The validator function.
     * @throws InvalidArgumentException If the attribute is unknown.
     */
    private function getValidator(string $attributeName): callable
    {
        return match ($attributeName) {
            'CommissionCalculator\Attributes\NotEmpty' => [$this, 'validateNotEmpty'],
            'CommissionCalculator\Attributes\Numeric' => [$this, 'validateNumeric'],
            'CommissionCalculator\Attributes\EnumValue' => [$this, 'validateEnumValue'],
            default => throw new InvalidArgumentException("Unknown attribute: $attributeName"),
        };
    }

    /**
     * Validates that the value is not empty.
     *
     * @param mixed $value The value to validate.
     * @param object $attributeInstance The attribute instance.
     * @param ReflectionProperty $property The property being validated.
     * @param array &$errors The list of errors to append to if validation fails.
     */
    private function validateNotEmpty(
        mixed $value,
        object $attributeInstance,
        ReflectionProperty $property,
        array &$errors
    ): void {
        if (empty($value)) {
            $errors[] = "Property '{$property->getName()}' must not be empty.";
        }
    }
    /**
     * Validates that the value is numeric.
     *
     * @param mixed $value The value to validate.
     * @param object $attributeInstance The attribute instance.
     * @param ReflectionProperty $property The property being validated.
     * @param array &$errors The list of errors to append to if validation fails.
     */
    private function validateNumeric(
        mixed $value,
        object $attributeInstance,
        ReflectionProperty $property,
        array &$errors
    ): void {
        if (!is_numeric($value)) {
            $errors[] = "Property '{$property->getName()}' must be numeric.";
        }
    }
    /**
     * Validates that the value is a valid enum value.
     *
     * @param mixed $value The value to validate.
     * @param object $attributeInstance The attribute instance.
     * @param ReflectionProperty $property The property being validated.
     * @param array &$errors The list of errors to append to if validation fails.
     */
    private function validateEnumValue(
        mixed $value,
        object $attributeInstance,
        ReflectionProperty $property,
        array &$errors
    ): void {
        $enumClass = $attributeInstance->getEnumClass();
        if (!enum_exists($enumClass)) {
            $errors[] = "Property '{$property->getName()}' has not valid enum attribute.";
        }
        if (!in_array($value, $enumClass::cases())) {
            $errors[] = "Property '{$property->getName()}' must be a valid value of enum '$enumClass'.";
        }
    }
}
