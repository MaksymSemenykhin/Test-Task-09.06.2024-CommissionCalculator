<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\FileOutputAbstract;

readonly class XmlFileOutput extends FileOutputAbstract
{
    /**
     * Outputs the results to an XML file.
     *
     * @param array $results The results to output.
     * @return void
     */
    public function output(array $results): void
    {
        $xml = new \SimpleXMLElement('<results/>');
        foreach ($results as $result) {
            $xml->addChild('result', $result);
        }

        $this->directoryCheck();
        $xml->asXML($this->getFullPath());
    }
}
