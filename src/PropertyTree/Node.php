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

namespace Switchbox\PropertyTree;

/**
 * Represents a single node in the configuration data tree.
 */
class Node
{
    /**
     * The name of the node.
     * 
     * @type string
     */
    protected $name;

    /**
     * The value data of the node.
     * 
     * @type mixed
     */
    protected $value;

    /**
     * Indicates if this node has changed since it was last persisted.
     * 
     * @type bool
     */
    protected $changed = false;

    /**
     * Contains an array of nodes that are children of this node.
     * 
     * @type NodeList
     */
    protected $childNodes;

    /**
     * The parent node that this node belongs to.
     * 
     * @type Node
     */
    protected $parentNode;

    /**
     * Creates a new configuration node with a given name and value.
     *
     * @param string $name
     * The name of the node.
     *
     * @param mixed $value
     * The value to assign to the node.
     */
    public function __construct($name = null, $value = null)
    {
        $this->childNodes = new NodeList();

        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Gets the name of the node.
     *
     * @return string
     * The name of the node.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the node.
     *
     * @param string $name
     * The new name of the property.
     *
     * @return void
     *
     * @throws \DomainException
     * Thrown if `$name` is not a string or null.
     */
    public function setName($name)
    {
        // check if $name is a valid name
        if (!is_string($name) && $name !== null)
        {
            throw new \DomainException('Node name must be a string or null.');
        }

        $this->name = $name;
    }

    /**
     * Gets the value data of the node.
     *
     * @return mixed
     * The value data of the node.
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
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Checks if this node has any children.
     * 
     * @return bool
     * True if this node has at least one child node, otherwise false.
     */
    public function hasChildNodes()
    {
        return count($this->childNodes) > 0;
    }

    /**
     * Gets a node list of nodes that are children of this node.
     *
     * @return NodeList
     * An array of nodes that are children of this node.
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * Gets the parent node that this node belongs to.
     *
     * @return Node
     * The parent node that this node belongs to.
     */
    public function getParentNode()
    {
        return $this->parentNode;
    }

    /**
     * Adds a configuration node to the node's list of children.
     *
     * @param Node $node
     * The configuration node to append.
     * 
     * @return Node
     * The node that was just appended.
     */
    public function appendChild(Node $node)
    {
        // push node to children
        $this->childNodes->addNode($node);

        // set this node as parent
        $node->parentNode = $this;

        // return added node
        return $node;
    }

    /**
     * Removes a configuration node from the node's list of children.
     *
     * @param Node $node
     * The configuration node to remove.
     *
     * @return Node
     * The node that was just removed.
     */
    public function removeChild(Node $node)
    {
        // remove the node from the list of children
        $this->childNodes->removeNode($node);

        // orphanize the node
        $node->parentNode = null;

        // return the removed node
        return $node;
    }
}
