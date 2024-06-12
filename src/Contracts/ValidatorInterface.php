<?php

namespace CommissionCalculator\Contracts;

/**
 * ValidatorInterface is interface for subsequent implementations of validation by different classes using inheritance
 * @package CommissionCalculator\Contracts
 */
interface ValidatorInterface
{
    /**
     * Validates the given data.
     *
     * @param array $data The data to validate.
     * @return array List of validation errors, if any.
     */
    public function validate(array $data): array;
}
