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
 * Contains a list of configuration nodes.
 */
class NodeList implements \IteratorAggregate, \Countable
{
    /**
     * Contains a list of nodes that belong to this node list.
     * 
     * @type Node[]
     */
    protected $nodes = array();

    /**
     * Gets the number of nodes in the list.
     *
     * @return int
     * The number of nodes in the list.
     */
    public function count()
    {
        return count($this->nodes);
    }

    /**
     * Gets a new iterator for looping over the list.
     *
     * @return NodeListIterator
     * An iterator that facilitates iterating over the node list.
     */
    public function getIterator()
    {
        return new NodeListIterator($this);
    }

    /**
     * Checks if the node list contains the given node.
     *
     * @param Node $node
     * The node to check.
     *
     * @return bool
     * True if `$node` is in the node list at least once, otherwise false.
     */
    public function contains(Node $node)
    {
        return in_array($node, $this->nodes, true);
    }

    /**
     * Gets the node at the given index.
     *
     * @param int $index
     * The index of the node to get.
     *
     * @return Node
     * The node at the given index.
     *
     * @throws \OutOfRangeException
     * Thrown if a non-integer is passed for `$index` or if `$index` is less
     * than zero.
     *
     * @throws \OutOfBoundsException
     * Thrown if the given index does not exist.
     */
    public function getNode($index)
    {
        if (!is_int($index) || $index < 0)
        {
            throw new \OutOfRangeException('Index must be a positive integer.');
        }

        if ($index >= $this->count())
        {
            throw new \OutOfBoundsException("The index '{$index}' does not exist.");
        }

        return $this->nodes[$index];
    }

    /**
     * Gets all child nodes in the node list with a given name as a new
     * node list.
     *
     * @param string $name
     * The name that nodes should match. Name comparison is case-sensitive.
     *
     * @return NodeList
     * A node list containing all nodes with the given name.
     */
    public function getNodesByName($name)
    {
        $nodeList = new self();

        foreach ($this->nodes as $node)
        {
            if ($node->getName() === $name)
            {
                $nodeList->addNode($node);
            }
        }

        return $nodeList;
    }

    /**
     * Adds a node to the node list.
     *
     * This method is used for manipulating lists of nodes only. Use
     * {@see Node::appendChild} for adding nodes to a node tree.
     *
     * @param Node $node
     * The node to add.
     *
     * @return void
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * Removes all occurrences of a given node from the node list.
     *
     * This method is used for manipulating lists of nodes only. Use
     * {@see Node::removeChild} for removing nodes from a node tree.
     *
     * @param Node $node
     * The node to remove.
     *
     * @return void
     */
    public function removeNode(Node $node)
    {
        // loop over the array of child nodes
        for ($i = 0, $n = count($this->nodes); $i < $n; $i++)
        {
            // is the current node the one we are looking for?
            if ($this->nodes[$i] === $node)
            {
                // remove the node from the array
                unset($this->nodes[$i]);
            }
        }

        // re-index the array
        $this->nodes = array_values($this->nodes);
    }

    /**
     * Removes the node at the given index.
     *
     * This method is used for manipulating lists of nodes only. Use
     * {@see Node::removeChild} for removing nodes from a node tree.
     *
     * @param int $index
     * The index of the node to remove.
     *
     * @return void
     *
     * @throws \OutOfRangeException
     * Thrown if a non-integer is passed for `$index` or if `$index` is less
     * than zero.
     *
     * @throws \OutOfBoundsException
     * Thrown if the given index does not exist.
     */
    public function removeNodeByIndex($index)
    {
        if (!is_int($index) || $index < 0)
        {
            throw new \OutOfRangeException('Index must be a positive integer.');
        }

        if ($index >= $this->count())
        {
            throw new \OutOfBoundsException("The index '{$index}' does not exist.");
        }

        array_splice($this->nodes, $index, 1);
    }

    /**
     * Removes all nodes from the node list.
     *
     * @return void
     */
    public function clear()
    {
        $this->nodes = array();
    }
}
