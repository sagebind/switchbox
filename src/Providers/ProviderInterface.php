<?php
namespace Switchbox\Providers;

use Exception;
use Switchbox\ConfigurationNode;

/**
 * Interface that
 */
interface ProviderInterface
{
    /**
     * Loads a property collection from the provider source.
     * 
     * @return ConfigurationNode $properties
     */
    public function load();

    /**
     * Saves a property collection to the provider source.
     * 
     * @param ConfigurationNode $properties [description]
     */
    public function save(ConfigurationNode $properties);
}

class ProviderException extends Exception
{}
