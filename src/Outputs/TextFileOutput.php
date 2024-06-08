<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;

class TextFileOutput implements OutputInterface
{
    private $filePath;

    /**
     * TextFileOutput constructor.
     *
     * @param string $filePath Path to the output file.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Outputs the results to a text file.
     *
     * @param array $results The results to output.
     * @return void
     */
    public function output(array $results): void
    {
        file_put_contents($this->filePath, implode(PHP_EOL, $results) . PHP_EOL);
    }
}
