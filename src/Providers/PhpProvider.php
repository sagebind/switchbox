<?php
namespace Switchbox\Providers;

use UnexpectedValueException;
use Switchbox\ConfigurationProperty;

/**
 * Loads settings configuration from a PHP script file.
 */
class PhpProvider extends FileProvider
{
    /**
     * Loads settings configuration from file.
     *
     * @return ConfigurationProperty
     * The configuration contained in the file.
     */
    public function load()
    {
        // make sure the file is readable
        if (!is_readable($this->fileName))
        {
            throw new FileNotFoundException("The file '{$this->fileName}' is not readable.");
        }

        // parse the file
        $returnValue = include($this->fileName);

        // return value must be an array
        if (!is_array($returnValue))
        {
            throw new UnexpectedValueException("The file '{$this->fileName}' does not return an array.");
        }

        // return a config tree from the returned array
        return ConfigurationProperty::fromArray($returnValue);
    }

    public function save(ConfigurationProperty $configuration)
    {
        throw new NotImplementedException("Settings configuration cannot be saved to PHP script files.");
    }
}
