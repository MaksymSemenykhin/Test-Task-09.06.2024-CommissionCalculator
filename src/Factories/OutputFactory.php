<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Contracts\OutputInterface;
use CommissionCalculator\Outputs\ConsoleOutput;
use CommissionCalculator\Outputs\TextFileOutput;
use CommissionCalculator\Outputs\XmlFileOutput;
use CommissionCalculator\Enums\OutputType;
use Exception;

class OutputFactory
{
    /**
     * Creates the appropriate output handler based on the configuration.
     *
     * @param array $config
     * @return OutputInterface
     * @throws Exception
     */
    public function createOutputHandler(array $config): OutputInterface
    {

        if (!isset($config['type'])) {
            throw new Exception('Output type not specified');
        }

        if (!isset($config['file_path'])) {
            throw new Exception('Output file path not specified');
        }
        return match ($config['type']) {
            OutputType::Txt => new TextFileOutput($config['file_path'],$config['file_name']),
            OutputType::Xml => new XmlFileOutput($config['file_path'],$config['file_name']),
            OutputType::Console => new ConsoleOutput(),
        };
    }
}
