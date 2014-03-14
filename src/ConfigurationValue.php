<?php
namespace Switchbox;

/**
 * Represents a single configuration value in the configuration tree.
 */
class ConfigurationValue extends ConfigurationNode
{
    /**
     * The value data of the configuration value.
     * @var mixed
     */
    protected $value;

    /**
     * Creates a new configuration value node with a given value.
     *
     * @param mixed $value
     * The value to assign to the value node.
     */
    public function __construct($value)
    {
        $this->setValue($value);
    }

    /**
     * Gets the value data of the configuration value.
     *
     * @return mixed
     * The value data of the configuration value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value data of the configuration value.
     *
     * @param mixed $value
     * The value data of the configuration value.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
