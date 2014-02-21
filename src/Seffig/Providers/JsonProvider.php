<?php
namespace Seffig\Providers;

use Seffig\PropertyValue;
use Seffig\PropertyCollection;

class JsonProvider implements ProviderInterface
{
    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function load()
    {
        // load the json object tree into an array
        $array = json_decode(file_get_contents($this->fileName), true);

        // return the array as a property collection
        return PropertyCollection::fromArray($array);
    }

    public function save(PropertyValue $properties)
    {
        // turn the property list into an array
        $array = $properties->toArray();

        // serialize the array to json and save it to the settings file
        file_put_contents($this->fileName, json_encode($array));
    }
}
