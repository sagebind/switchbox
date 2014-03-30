<?php
namespace Switchbox\Providers;

use Switchbox\ConfigurationProperty;

/**
 * Loads and saves settings configuration from a JSON file.
 */
class JsonProvider extends FileProvider
{
    /**
     * Loads settings configuration from the JSON file.
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

        // load the json data from file
        $json = file_get_contents($this->fileName);

        // load the json object tree into an array
        $array = json_decode($json, true);

        // return a config tree from the array
        return ConfigurationProperty::fromArray(null, $array);
    }

    /**
     * Saves settings configuration to the JSON file.
     *
     * @param ConfigurationProperty $config
     * The settings configuration to save.
     */
    public function save(ConfigurationProperty $config)
    {
        // turn the config tree into an array
        $array = $config->toArray();

        // serialize the array to a json string
        $json = json_encode($array, JSON_PRETTY_PRINT);

        // write the json to file
        file_put_contents($this->fileName, $json);
    }
}
