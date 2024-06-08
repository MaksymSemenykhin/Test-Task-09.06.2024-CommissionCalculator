<?php

namespace CommissionCalculator\Outputs;

use CommissionCalculator\Contracts\OutputInterface;

class XmlFileOutput implements OutputInterface
{
    private $filePath;

    /**
     * XmlFileOutput constructor.
     *
     * @param string $filePath Path to the output file.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

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
        $xml->asXML($this->filePath);
    }
}
