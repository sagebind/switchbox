<?php
namespace Seffig;

use Exception;
use Seffig\Providers\ProviderInterface;

class Settings extends ConfigurationNode
{
    protected $providers = array();

    /**
     * Creates a new settings object with a default provider.
     *
     * @param  ProviderInterface $provider [description]
     *
     * @return [type]                      [description]
     */
    public function __construct(ProviderInterface $provider = null)
    {
    }

    /**
     * Gets the settings provider
     *
     * @return ProviderInterface[]
     * The settings provider of the specified profile.
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Creates a new settings profile with a given provider.
     * 
     * @param ProviderInterface $provider
     * The source provider of the profile.
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * Loads property values from the settings providers.
     */
    public function load()
    {
        $this->children = array();

        foreach ($this->providers as $provider)
        {
            $this->children = array_merge($this->children, $provider->load()->children);
        }
    }

    /**
     * [save description]
     * 
     * @param  [type] $profile [description]
     * @return [type]          [description]
     */
    public function save(ProviderInterface $provider = null)
    {
        if ($provider === null) $provider = $this->provider;

        $provider->save($this->rootProperty);
        $rootProperty =& $this->rootProperty[$this->profile];
        $rootProperty->save();
    }
}
