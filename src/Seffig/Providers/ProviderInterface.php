<?php
namespace Seffig\Providers;

use Exception;
use Seffig\PropertyCollection;

/**
 * Interface that
 */
interface ProviderInterface
{
    /**
     * Loads a property collection from the provider source.
     * 
     * @return PropertyCollection $properties
     */
    public function load();

    /**
     * Saves a property collection to the provider source.
     * 
     * @param PropertyCollection $properties [description]
     */
    public function save(PropertyCollection $properties);
}

class ProviderException extends Exception
{}
