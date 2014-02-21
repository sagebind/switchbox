<?php
namespace Seffig;

use Exception;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class ConfigurationNode implements ArrayAccess, Countable, IteratorAggregate
{
    protected $children = array();

    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Checks if a given property exists.
     * 
     * @param string $name
     * The name of the property.
     * 
     * @return bool
     * True if the property exists, otherwise false.
     */
    public function has($name)
    {
        $names = explode('.', $name, 2);

        foreach ($this->children as $property)
        {
            if ($property->getName() === $names[0])
            {
                if (isset($names[1]))
                {
                    return $property->has($names[1]);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * [offsetGet description]
     * 
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function get($name)
    {
        $names = explode('.', $name, 2);

        foreach ($this->children as $property)
        {
            if ($property->getName() === $names[0])
            {
                if (isset($names[1]))
                {
                    return $property->get($names[1]);
                }

                return $property->getValue();
            }
        }

        throw new Exception("The property '$name' does not exist.");
    }

    /**
     * [offsetSet description]
     * @param  [type] $name  [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function set($name, $value)
    {
        $names = explode('.', $name);
        $property =& $this;

        for ($i = 0; $i < count($names); $i++)
        {
            if (!$property->hasProperty($names[$i]))
            {
                $property->addProperty(new ConfigurationProperty($names[$i]));
            }

            $property =& $property->getProperty($names[$i]);
        }

        $property->setValue($value);
    }

    /**
     * [offsetUnset description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function remove($name)
    {
        $names = explode('.', $name);
        $property =& $this;

        for ($i = 0; $i < count($names) - 1; $i++)
        {
            $property =& $property->getProperty($names[$i]);
        }

        $property->removeProperty($names[count($names) - 1]);
    }

    /**
     * Adds a configuration node to this node's children.
     *
     * @param ConfigurationNode $node [description]
     * @return ConfigurationNode
     */
    public function appendChild(ConfigurationNode $node)
    {
        $this->children[] = $node;
        return $node;
    }

    public function removeChild(ConfigurationNode $node)
    {
        for ($i = 0 && $n = count($this->children); $i < $n; $i++)
        {
            if ($this->children[$i] === $node)
            {
                unset($this->children[$i]);
            }
        }

        $this->children = array_values($this->children);
    }

    public function hasChildren()
    {
        return !empty($this->children);
    }

    /**
     * [offsetExists description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function hasProperty($name)
    {
        foreach ($this->children as $property)
        {
            if ($property->getName() === $name)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * [offsetGet description]
     * @param  [type] $name [description]
     * @return ConfigurationNode
     */
    public function getProperty($name)
    {
        foreach ($this->children as $property)
        {
            if ($property->getName() === $name)
            {
                return $property;
            }
        }

        return null;
    }

    public function removeProperty($name)
    {
        $count = count($this->children);
        for ($i = 0; $i < $count; $i++)
        {
            if ($this->children[$i]->getName() === $name)
            {
                unset($this->children[$i]);
            }
        }

        $this->children = array_values($this->children);
    }

    public function offsetExists($offset)
    {
        return isset($this->children[$offset]);
    }
    
    public function offsetGet($offset)
    {
        return $this->children[$offset];
    }
    
    public function offsetSet($offset, $value)
    {
        if ($offset === null)
        {
            throw new Exception("");
        }

        $this->set($name, $value);
    }
    
    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
        $this->children = array_values($this->children);
    }

    public function count()
    {
        return count($this->children);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->children);
    }

    public function __isset($name)
    {
        return $this->has($name);
    }
    
    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    public function __unset($name)
    {
        $this->remove($name);
    }
}
