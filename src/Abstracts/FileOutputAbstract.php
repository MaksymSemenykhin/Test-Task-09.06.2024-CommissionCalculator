<?php

namespace CommissionCalculator\Abstracts;

use CommissionCalculator\Contracts\OutputInterface;
use Exception;

/**
 * FileOutputAbstract provides a base implementation for file output handling and serves as a
 * foundation for more specific file output classes.
 * Subclasses of FileOutputAbstract must implement the output() method to handle the actual file output logic.
 */

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
     * @throws Exception
     */
    public function output(array $results): ?array
    {
        throw new Exception('function output not implemented in FileOutputAbstract');
    }
    /**
     * Returns the full path of the file.
     *
     * @return string The full path of the file.
     */
    protected function getFullPath(): string
    {
        return trim($this->filePath, '/') . DIRECTORY_SEPARATOR . $this->fileName;
    }
    /**
     * Checks if the directory specified by $this->filePath exists, and creates it if it doesn't.
     * If the directory cannot be created, it terminates the program with an error message.
     *
     * @throws Exception if the directory cannot be created.
     * @return void
     */
    protected function directoryCheck(): void
    {
        is_dir($this->filePath) || mkdir($this->filePath) || die("Can't Create folder from path: {$this->filePath}");
    }
}
