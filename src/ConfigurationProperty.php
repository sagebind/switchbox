<?php
namespace Switchbox;

use DomainException;

/**
 * Represents a single property in the configuration tree.
 */
class ConfigurationProperty extends ConfigurationNode
{
    /**
     * The name of the property.
     * @var string
     */
    protected $name;

    /**
     * Creates a new configuration property with a specified name.
     *
     * @param string $name
     * The name of the property.
     */
    public function __construct($name = null)
    {
        $this->setName($name);
    }

    /**
     * Creates a configuration tree from an array tree.
     * 
     * @param mixed[] $array
     * The array containing the data to create a configuration tree from.
     *
     * @param string $name
     * The name of the property.
     * 
     * @return ConfigurationProperty
     */
    public static function fromArray($name, array $array)
    {
        // create a config property node
        $propertyNode = new static($name);

        // loop over the array
        foreach ($array as $key => $value)
        {
            // value is a property if the key is a name
            if (is_string($key))
            {
                // recursive call if value is also an array
                if (is_array($value))
                {
                    // append a property node from the array value with the key
                    // as the name
                    $propertyNode->appendChild(static::fromArray($key, $value));
                }

                // scalar value
                else
                {
                    // create a property node with the key as the name
                    $childNode = $propertyNode->appendChild(new static($key));

                    // child has only one value
                    $childNode->setUniparousity(true);

                    // add a value to the property node
                    $childNode->appendChild(new ConfigurationValue($value));
                }
            }

            // value is a configuration value if key isn't a name
            else
            {
                // add the value to the property node
                $propertyNode->appendChild(new ConfigurationValue($value));
            }
        }

        // return the filled property node
        return $propertyNode;
    }

    /**
     * Gets the name of the property.
     *
     * @return string
     * The name of the property.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the property.
     *
     * @param string $name
     * The new name of the property.
     */
    public function setName($name)
    {
        // check if $name is a valid name
        if (!is_string($name) && $name !== null)
        {
            throw new DomainException("Property name must be a string or null.");
        }

        $this->name = $name;
    }

    /**
     * Gets an array of configuration property nodes that belong to this node.
     *
     * @return ConfigurationProperty[]
     * An array of property nodes that belong to this node.
     */
    public function getProperties()
    {
        // store an array of property nodes
        $propertyNodes = array();

        foreach ($this->children as $childNode)
        {
            // child node is a property
            if ($childNode instanceof self)
            {
                $propertyNodes[] = $childNode;
            }
        }

        return $propertyNodes;
    }

    /**
     * Gets an array of configuration value nodes that belong to this node.
     *
     * @return ConfigurationValue[]
     * An array of value nodes that belong to this node.
     */
    public function getValues()
    {
        $valueNodes = array();

        foreach ($this->children as $childNode)
        {
            // child node is a value node
            if ($childNode instanceof ConfigurationValue)
            {
                $valueNodes[] = $childNode;
            }
        }

        return $valueNodes;
    }

    /**
     * Checks if this configuration property has a child property with a given
     * name.
     * 
     * @param string $name
     * The name of the configuration property to check.
     * 
     * @return bool
     * True if this configuration property has a child property with the
     * specified name, otherwise false.
     */
    public function hasProperty($name)
    {
        return $this->getProperty($name) !== null;
    }

    /**
     * Gets a child configuration property with a given name.
     * 
     * @param string $name
     * The name of the configuration property to get.
     * 
     * @return ConfigurationNode
     * The configuration property with the specified name. Returns null if no
     * property exists with the specified name.
     */
    public function getProperty($name)
    {
        foreach ($this->children as $childNode)
        {
            if ($childNode instanceof self && $childNode->getName() === $name)
            {
                // child is a property and name matches the name we are
                // looking for
                return $childNode;
            }
        }

        return null;
    }

    /**
     * Removes a child configuration property with a given name.
     * 
     * @param string $name
     * The name of the configuration property to remove.
     * 
     * @return ConfigurationNode|false
     * The configuration property that was removed, or false if no property
     * exists with the specified name.
     */
    public function removeProperty($name)
    {
        // get the node by the name
        $node = $this->getProperty($name);

        // does the node exist?
        if ($node !== null)
        {
            // remove the node from the list of children
            return $this->removeChild($node);
        }

        // return the removed property node
        return false;
    }

    /**
     * Gets the configuration property as an array tree of property values.
     *
     * @return mixed[]
     * The array tree of the property values.
     */
    public function toArray()
    {
        $array = array();

        // add property nodes
        foreach ($this->getProperties() as $childNode)
        {
            // assign the property value to the child array
            $array[$childNode->getName()] = $childNode->toArray();
        }

        // add value nodes
        foreach ($this->getValues() as $childNode)
        {
            $array[] = $childNode->getValue();
        }

        // is there only one value?
        if ($this->uniparous && count($array) === 1)
        {
            // assign the property value to the first child if only one
            // value exists
            return $array[0];
        }

        // return the array
        return $array;
    }
}
