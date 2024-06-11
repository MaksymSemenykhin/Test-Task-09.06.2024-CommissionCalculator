<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Abstracts\FileOutputAbstract;
use CommissionCalculator\Traits\RoundingTrait;
use Exception;

readonly class TextFileOutput extends FileOutputAbstract
{
    use RoundingTrait;

    /**
     * Outputs the results to a text file.
     *
     * @param array $results The results to output.
     * @return array|null
     * @throws Exception
     */
    public function output(array $results): ?array
    {
        $resultsFormated = [];
        $this->directoryCheck();
        foreach ($results as $result) {
            $resultsFormated[] = $this->formatAmount($result['amount'], $result['currency']);
        }

        file_put_contents($this->getFullPath(), implode(PHP_EOL, $resultsFormated) . PHP_EOL);

        return null;
    }
}
