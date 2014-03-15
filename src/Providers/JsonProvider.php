<?php
namespace Switchbox\Providers;

use Switchbox\ConfigurationProperty;

/**
 * Loads and saves settings configuration from a JSON file.
 */
class JsonProvider extends FileProvider
{
    /**
     * Loads settings configuration from file.
     *
     * @return ConfigurationProperty
     * The configuration contained in the file.
     */
    public function load()
    {
        // load the json object tree into an array
        $array = json_decode(file_get_contents($this->fileName), true);

        // return the array as a property collection
        return ConfigurationProperty::fromArray(null, $array);
    }

    /**
     * Saves settings configuration to file
     *
     * @param ConfigurationProperty $configuration
     * The settings configuration to save.
     */
    public function save(ConfigurationProperty $configuration)
    {
        // turn the property list into an array
        $array = $properties->toArray();

        // serialize the array to json and save it to the settings file
        file_put_contents($this->fileName, json_encode($array));
    }
}
