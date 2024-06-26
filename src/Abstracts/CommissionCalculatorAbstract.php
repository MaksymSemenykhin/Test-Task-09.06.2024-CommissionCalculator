<?php

namespace CommissionCalculator\Abstracts;

use CommissionCalculator\Factories\ServiceFactory;

/**
 * CommissionCalculatorAbstract is a base for CalculatorTest and CommissionCalculator implementations
 * which are main apps classes
 *
 * @package CommissionCalculator\Abstracts
 */
abstract class CommissionCalculatorAbstract
{
    /**
     * Initializes a new instance of the class.
     *
     * @param ServiceFactory $serviceFactory The service factory.
     */
    abstract public function __construct(ServiceFactory $serviceFactory);

    protected ServiceFactory $serviceFactory;
    /**
     * Retrieves the configuration data for the commission calculator.
     *
     * @return array The configuration data for the commission calculator.
     */
    public function getConfig(): array
    {
        return $this->serviceFactory->config;
    }
}
