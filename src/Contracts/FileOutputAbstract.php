<?php

namespace CommissionCalculator\Contracts;

readonly abstract class FileOutputAbstract implements OutputInterface
{
    /**
     * TextFileOutput constructor.
     *
     * @param string $filePath Path to the output file.
     * @param string $fileName name of result file.
     */
    public function __construct(private string $filePath, private string $fileName)
    {
    }

    /**
     * @throws \Exception
     */
    public function output(array $results): void
    {
        throw new \Exception('function output not implemented in FileOutputAbstract');
    }
    protected function GetFullPath(): string
    {
        return trim($this->filePath,'/').DIRECTORY_SEPARATOR . $this->fileName;
    }
    protected function directoryCheck(): void
    {
        is_dir($this->filePath) || @mkdir($this->filePath) || die("Can't Create folder from path: {$this->filePath}");
    }
}
