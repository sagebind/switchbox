<?php
namespace Seffig;

class ConfigurationProperty extends ConfigurationNode
{
    protected $name;
    protected $value;

    /**
     * Creates a property list from an associative array.
     * @param  mixed[]      $array [description]
     * @return PropertyList        [description]
     */
    public static function fromArray(array $array)
    {
        $propertyCollection = new static();

        foreach ($array as $name => $value)
        {
            if (is_array($value) && count(array_filter(array_keys($array), 'is_string')) > 0)
            {
                $propertyCollection->collections[$name] = static::fromArray($value);
            }

            else
            {
                $propertyCollection->properties[$name] = $value;
            }
        }

        return $propertyCollection;
    }

    public function __construct($name, $value = null)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (!is_string($name))
        {
            throw new Exception("Property name must be a string.");
        }

        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function toArray()
    {
        $array = array();

        foreach ($this->properties as $name => $value)
        {
            if ($value instanceof self)
            {
                $array[$name] = $value->toArray();
            }

            else
            {
                $array[$name] = $value;
            }
        }
    }
}
