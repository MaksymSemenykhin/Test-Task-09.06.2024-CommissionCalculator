<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Abstracts\FileOutputAbstract;
use CommissionCalculator\Traits\RoundingTrait;
use Exception;

/**
 * TextFileOutput formats and outputs results to a text file.
 * This class extends `FileOutputAbstract` to handle file-specific operations
 * and uses `RoundingTrait` to format amounts according to the currency's precision.
 * It ensures the target directory exists and writes the formatted results to the specified text file.
 *
 * Methods:
 * - `output(array $results): ?array`
 *   Formats the results and writes them to a text file.
 *
 * @package CommissionCalculator\Outputs
 */
readonly class TextFileOutput extends FileOutputAbstract
{
    use RoundingTrait;

    /**
     * Outputs the results to a text file.
     *
     * @param array $results The results to output.
     * @return array|null Always returns null after writing to the text file.
     * @throws Exception If unable to write to the specified file path.
     */
    public function output(array $results): ?array
    {
        $resultsFormatted = [];
        $this->directoryCheck();

        foreach ($results as $result) {
            $resultsFormatted[] = $this->formatAmount($result['amount'], $result['currency']);
        }

        file_put_contents($this->getFullPath(), implode(PHP_EOL, $resultsFormatted) . PHP_EOL);

        return null;
    }
}
