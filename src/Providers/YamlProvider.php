<?php
namespace Switchbox\Providers;

use Switchbox\ConfigurationProperty;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

/**
 * Loads and saves settings configuration from a YAML file.
 */
class YamlProvider extends FileProvider
{
    /**
     * Loads settings configuration from the YAML file.
     *
     * @return ConfigurationProperty
     * The configuration contained in the file.
     */
    public function load()
    {
        // load the yaml contents from file
        $yaml = file_get_contents($this->fileName);

        // create a yaml parser engine
        $parser = new Parser();

        // parse the yaml to an array
        $array = $parser->parse($yaml);

        // return a config tree from the array
        return ConfigurationProperty::fromArray(null, $array);
    }

    /**
     * Saves settings configuration to the YAML file.
     *
     * @param ConfigurationProperty $configuration
     * The settings configuration to save.
     */
    public function save(ConfigurationProperty $config)
    {
        // turn the config tree into an array
        $array = $config->toArray();

        // create a yaml dumper
        $dumper = new Dumper();

        // serialize the array to a yaml string
        $yaml = $dumper->dump($array, 4);

        // write the yaml to file
        file_put_contents($this->fileName, $yaml);
    }
}
