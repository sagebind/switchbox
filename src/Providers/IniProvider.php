<?php
namespace Switchbox\Providers;

use Exception;
use SplFileObject;
use Switchbox\ConfigurationProperty;

/**
 * Loads and saves settings configuration from an INI file.
 */
class IniProvider extends FileProvider
{
    /**
     * Indicates if settings should be divided up and grouped by section headers.
     * @var bool
     */
    protected $processSections = true;

    /**
     * Creates a new INI file provider with a given file name.
     *
     * @param string $fileName
     * The file path of the file containing configuration values.
     *
     * @param bool $processSections
     * Indicates if settings should be divided up and grouped by section headers.
     */
    public function __construct($fileName, $processSections = true)
    {
        parent::__construct($fileName);
        $this->processSections = $processSections;
    }

    /**
     * Loads settings configuration from the INI file.
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

        // load the ini keys into an array
        $array = parse_ini_file($this->fileName, $this->processSections, INI_SCANNER_RAW);

        // check for parse errors
        if ($array === false)
        {
            throw new Exception("Syntax error in file '{$this->fileName}'.");
        }

        // return a config tree from the array
        return ConfigurationProperty::fromArray(null, $array);
    }

    /**
     * Saves settings configuration to the INI file.
     *
     * @param ConfigurationProperty $config
     * The settings configuration to save.
     */
    public function save(ConfigurationProperty $config)
    {
        // open the file for writing
        $fileStream = new SplFileObject($this->fileName, 'wb');

        if ($this->processSections)
        {
            $sectionNodes = array();
            $sectionlessKeys = false;

            foreach ($config->getProperties() as $propertyNode)
            {
                if (count($propertyNode->getProperties()) === 0)
                {
                    $sectionlessKeys = true;
                    $this->writeProperty($fileStream, $propertyNode);
                }

                else
                {
                    $sectionNodes[] = $propertyNode;
                }
            }

            if ($sectionlessKeys)
            {
                $fileStream->fwrite("\r\n");
            }

            foreach ($sectionNodes as $sectionNode)
            {
                $fileStream->fwrite('[' . $sectionNode->getName() . "]\r\n");

                foreach ($sectionNode->getProperties() as $propertyNode)
                {
                    $this->writeProperty($fileStream, $propertyNode);
                }

                $fileStream->fwrite("\r\n");
            }
        } 
        
        else
        {
            foreach ($config->getProperties() as $propertyNode)
            {
                $this->writeProperty($fileStream, $propertyNode);
            }
        }

        // close the file
        $fileStream = null;
    }

    private function writeProperty($fileStream, ConfigurationProperty $propertyNode)
    {
        if ($propertyNode->isUniparous())
        {
            $fileStream->fwrite($propertyNode->getName());
            $fileStream->fwrite(' = ');

            if ($propertyNode->count() > 0)
            {
                $valueNode = $propertyNode->getValues()[0];
                $fileStream->fwrite($valueNode->getValue());
            }

            $fileStream->fwrite("\r\n");
        }

        else
        {
            foreach ($propertyNode->getValues() as $valueNode)
            {
                $fileStream->fwrite($propertyNode->getName());
                $fileStream->fwrite('[] = ');
                $fileStream->fwrite($valueNode->getValue());
                $fileStream->fwrite("\r\n");
            }
        }
    }
}
