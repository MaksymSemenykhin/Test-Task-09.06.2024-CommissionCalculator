<?php

namespace CommissionCalculator\Factories;

use CommissionCalculator\Contracts\OutputInterface;
use CommissionCalculator\Outputs\ArrayOutput;
use CommissionCalculator\Outputs\ConsoleOutput;
use CommissionCalculator\Outputs\TextFileOutput;
use CommissionCalculator\Outputs\XmlFileOutput;
use CommissionCalculator\Enums\OutputType;
use Exception;

/**
 * OutputFactory creates instances of output handlers based on the provided configuration.
 * This factory decides which output handler to instantiate based on the `type` specified in the configuration.
 *
 * Methods:
 * - `createOutputHandler(array $config): OutputInterface`
 *   Creates an output handler based on the configuration type.
 *
 * Example:
 * ```
 * $factory = new OutputFactory();
 * $handler = $factory->createOutputHandler([
 *     'type' => OutputType::Txt,
 *     'file_path' => '/path/to/file',
 *     'file_name' => 'output.txt'
 * ]);
 * ```
 *
 * @package CommissionCalculator\Factories
 */
class OutputFactory
{
    /**
     * Creates the appropriate output handler based on the configuration.
     *
     * @param array $config The configuration array, which must include the 'type' key.
     * @return OutputInterface The appropriate output handler for the given configuration.
     * @throws Exception If the 'type' key is not specified in the configuration or is invalid.
     */
    public function createOutputHandler(array $config): OutputInterface
    {
        if (!isset($config['type'])) {
            throw new Exception('Output type not specified');
        }

        return match ($config['type']) {
            OutputType::Txt => new TextFileOutput($config['file_path'], $config['file_name']),
            OutputType::Xml => new XmlFileOutput($config['file_path'], $config['file_name']),
            OutputType::Console => new ConsoleOutput(),
            OutputType::Array => new ArrayOutput(),
            default => throw new Exception("Unsupported output type: {$config['type']}"),
        };
    }
}
