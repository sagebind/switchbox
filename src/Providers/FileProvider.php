<?php
namespace Switchbox\Providers;

/**
 * Loads and saves settings configuration from a file.
 */
abstract class FileProvider implements ProviderInterface
{
    /**
     * The file path of the file containing configuration values.
     * @var string
     */
    protected $fileName;

    /**
     * Creates a new file provider with a given file name.
     *
     * @param string $fileName
     * The file path of the file containing configuration values.
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Gets the file path of the file containing configuration values.
     *
     * @return string
     * The file path of the file containing configuration values.
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
