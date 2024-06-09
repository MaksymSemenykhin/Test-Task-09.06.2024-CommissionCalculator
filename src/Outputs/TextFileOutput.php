<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\FileOutputAbstract;

readonly class TextFileOutput extends FileOutputAbstract
{
    /**
     * Outputs the results to a text file.
     *
     * @param array $results The results to output.
     * @return void
     */
    public function output(array $results): void
    {
        $this->directoryCheck();
        file_put_contents($this->getFullPath(), implode(PHP_EOL, $results) . PHP_EOL);
    }
}
