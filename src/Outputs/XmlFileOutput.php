<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Abstracts\FileOutputAbstract;
use CommissionCalculator\Traits\RoundingTrait;
use Exception;

readonly class XmlFileOutput extends FileOutputAbstract
{
    use RoundingTrait;

    /**
     * Outputs the results to an XML file.
     *
     * @param array $results The results to output.
     * @return array|null
     * @throws Exception
     */
    public function output(array $results): ?array
    {
        $xml = new \SimpleXMLElement('<results/>');
        foreach ($results as $result) {
            $xml->addChild('result', $this->formatAmount($result['amount'], $result['currency']));
        }

        $this->directoryCheck();
        $xml->asXML($this->getFullPath());

        return null;
    }
}
