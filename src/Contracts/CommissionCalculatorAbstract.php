<?php

namespace CommissionCalculator\Contracts;

use CommissionCalculator\Factories\ServiceFactory;

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
