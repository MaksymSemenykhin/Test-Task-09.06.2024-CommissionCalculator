<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Abstracts\FileOutputAbstract;
use CommissionCalculator\Traits\RoundingTrait;
use Exception;
use SimpleXMLElement;

/**
 * XmlFileOutput formats and outputs results to an XML file.
 * This class extends `FileOutputAbstract` to handle file-specific operations
 * and uses `RoundingTrait` to format amounts according to the currency's precision.
 * It creates an XML structure with formatted results and writes it to the specified file.
 *
 * Methods:
 * - `output(array $results): ?array`
 *   Formats the results and writes them to an XML file.
 *
 * @package CommissionCalculator\Outputs
 */
readonly class XmlFileOutput extends FileOutputAbstract
{
    use RoundingTrait;

    /**
     * Outputs the results to an XML file.
     *
     * @param array $results The results to output.
     * @return array|null Always returns null after writing to the XML file.
     * @throws Exception If unable to write to the specified file path.
     */
    public function output(array $results): ?array
    {
        $xml = new SimpleXMLElement('<results/>');
        foreach ($results as $result) {
            $xml->addChild('result', $this->formatAmount($result['amount'], $result['currency']));
        }

        $this->directoryCheck();
        $xml->asXML($this->getFullPath());

        return null;
    }
}
