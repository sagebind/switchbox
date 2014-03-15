<?php
namespace Switchbox\Providers;

use Exception;
use Switchbox\ConfigurationProperty;

/**
 * Provides methods for loading and saving settings configuration from a source.
 */
interface ProviderInterface
{
    /**
     * Loads settings configuration from the provider source.
     * 
     * @return ConfigurationProperty
     * The settings configuration loaded from the provider source.
     */
    public function load();

    /**
     * Saves settings configuration to the provider source.
     * 
     * @param ConfigurationProperty $configuration
     * The settings configuration to save.
     */
    public function save(ConfigurationProperty $configuration);
}
