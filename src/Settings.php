<?php
namespace Switchbox;

use Exception;
use Switchbox\Providers\ProviderInterface;

class Settings
{
    /**
     * The configuration tree of the settings.
     *
     * @var ConfigurationNode
     */
    protected $configuration;
    protected $provider;

    /**
     * Creates a new settings object with a default provider.
     *
     * @param ProviderInterface $provider [description]
     */
    public function __construct(ProviderInterface $provider = null)
    {
        $this->configuration = new ConfigurationProperty();

        if ($provider !== null)
        {
            $this->setProvider($provider);
        }
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
        $names = explode('.', $name);
        $node = $this->configuration;

        for ($i = 0; $i < count($names); $i++)
        {
            if (!$node->hasProperty($names[$i]))
            {
                throw new Exception("The property '$name' does not exist.");
            }

            $node = $node->getProperty($names[$i]);
        }

        return $node->getValues()[0]->getValue();
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
        $node = $this->configuration;

        for ($i = 0; $i < count($names); $i++)
        {
            if (!$node->hasProperty($names[$i]))
            {
                $node->appendChild(new ConfigurationProperty($names[$i]));
            }

            $node = $node->getProperty($names[$i]);
        }

        $node->appendChild(new ConfigurationValue($value));
    }

    /**
     * [offsetUnset description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function remove($name)
    {
        $names = explode('.', $name);
        $node = $this->configuration;

        for ($i = 0; $i < count($names) - 1; $i++)
        {
            $property = $property->getProperty($names[$i]);
        }

        $property->removeProperty($names[count($names) - 1]);
    }

    /**
     * Gets the settings provider being used for loading and saving.
     *
     * @return ProviderInterface
     * The settings provider being used.
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Sets the settings provider to use for loading and saving.
     * 
     * @param ProviderInterface $provider
     * The settings provider to use.
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Loads settings configuration from the settings provider.
     * 
     * @return Settings
     * Self for method chaining.
     */
    public function load()
    {
        // load config data from the provider
        $this->configuration = $this->provider->load();

        // method chaining
        return $this;
    }

    /**
     * Saves the settings configuration to the settings provider.
     * 
     * @return Settings
     * Self for method chaining.
     */
    public function save()
    {
        // tell the provider to save the config data
        $this->provider->save($this->configuration);

        // method chaining
        return $this;
    }

    public function toArray()
    {
        return $this->configuration->toArray();
    }
}
