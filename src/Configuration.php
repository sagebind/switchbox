<?php
/*
 * Copyright 2014 Stephen Coakley <me@stephencoakley.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Switchbox;

/**
 * Base configuration class that implements storing properties as a tree.
 */
class Configuration implements \IteratorAggregate
{
    /**
     * @type PropertyTree\Node
     */
    protected $propertyTree;

    /**
     * @type ProviderInterface
     */
    protected $provider;

    /**
     * @type ExpressionEngineInterface
     */
    protected $expressionEngine;

    /**
     * Creates a new settings object with a default provider.
     *
     * @param ProviderInterface|null $provider
     */
    public function __construct(
        ProviderInterface $provider = null,
        ExpressionEngineInterface $expressionEngine = null
    ) {
        if ($provider)
            $this->provider = $provider;

        if ($expressionEngine)
            $this->expressionEngine = $expressionEngine;
        else
            $this->expressionEngine = new DefaultExpressionEngine();

        $this->propertyTree = new PropertyTree\Node('__ROOT__');
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
     *
     * @return void
     */
    public function setProvider(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Gets the expression engine being used for resolving property names.
     *
     * @return ExpressionEngineInterface
     * The expression engine being used.
     */
    public function getExpressionEngine()
    {
        return $this->expressionEngine;
    }

    /**
     * Sets the expression engine to use for resolving property names.
     *
     * @param ExpressionEngineInterface $expressionEngine
     * The expression engine to use.
     *
     * @return void
     */
    public function setExpressionEngine(ExpressionEngineInterface $expressionEngine)
    {
        $this->expressionEngine = $expressionEngine;
    }

    /**
     * Gets the root node of the property tree.
     *
     * @return PropertyTree\Node
     * The root node of the property tree.
     */
    public function getPropertyTree()
    {
        return $this->propertyTree;
    }

    /**
     * Sets the property tree that contains configuration data.
     *
     * @param PropertyTree\Node $node
     * The root node of a property tree.
     *
     * @return void
     */
    public function setPropertyTree(PropertyTree\Node $node)
    {
        $this->propertyTree = $node;
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
        $nodes = $this->expressionEngine->query($name, $this->propertyTree);

        // property exists if at least one node was found
        return count($nodes) > 0;
    }

    /**
     * Gets the value of a configuration property.
     *
     * @param string $name
     * An expression that reporesents the property whose value to get.
     *
     * @param mixed $default
     * A default value to return if the specified property does not exist.
     *
     * @return mixed
     * The value of the given property, or the default value if the specified
     * property does not exist.
     */
    public function get($name, $default = null)
    {
        $nodes = $this->expressionEngine->query($name, $this->propertyTree);

        if (count($nodes) > 0)
        {
            return $nodes->getNode(0)->getValue();
        }

        return $default;
    }

    /**
     * Sets the value of a configuration property.
     *
     * @param string $name
     * An expression that reporesents the property whose value to set.
     *
     * @param mixed $value
     * The value to set the given property to.
     *
     * @return void
     */
    public function set($name, $value)
    {
        $nodes = $this->expressionEngine->query($name, $this->propertyTree);

        for ($i = 0; $i < count($nodes); $i++)
        {
            $nodes->getNode($i)->setValue($value);
        }
        /*$names = explode('.', $name);
        $node = $this->configuration;

        for ($i = 0; $i < count($names); $i++)
        {
            if ($node->getNodeByName($names[$i]) === null)
            {
                $node = $node->appendChild(new ConfigurationNode($names[$i]));
            }
            else
            {
                $node = $node->getNodeByName($names[$i]);
            }
        }

        $node->setValue($value);*/
    }

    /**
     * Removes a configuration property.
     *
     * @param string $name
     * An expression that reporesents the property to remove.
     *
     * @return void
     */
    public function remove($name)
    {
        $nodes = $this->expressionEngine->query($name, $this->propertyTree);

        for ($i = 0; $i < count($nodes); $i++)
        {
            $nodes->getNode($i)->getParentNode()->removeChild($nodes->getNode($i));
        }
    }

    /**
     * Gets an iterator for looping over the entire configuration tree.
     *
     * @return \RecursiveIteratorIterator
     */
    public function getIterator($mode = 1)
    {
        return new \RecursiveIteratorIterator($this->propertyTree->getChildNodes()->getIterator(), $mode);
    }

    /**
     * Loads settings configuration from the settings provider.
     *
     * @return Configuration
     * Self for method chaining.
     */
    public function load()
    {
        // load config data from the provider
        $this->propertyTree = $this->provider->load();

        // method chaining
        return $this;
    }

    /**
     * Saves the settings configuration to the settings provider.
     *
     * @return Configuration
     * Self for method chaining.
     */
    public function save()
    {
        // tell the provider to save the config data
        $this->provider->save($this->propertyTree);

        // method chaining
        return $this;
    }
}
