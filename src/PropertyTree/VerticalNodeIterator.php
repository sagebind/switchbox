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
 * Iterates up a tree from a given node to the tree's root node.
 */
class VerticalNodeIterator implements \Iterator
{
    /**
     * @type Node
     */
    protected $firstNode;

    /**
     * @type Node
     */
    protected $currentNode;

    /**
     * @type int
     */
    protected $height = 0;

    /**
     * Creates a new vertical node iterator.
     *
     * @param Node $firstNode
     * The node that the iterator should start with.
     */
    public function __construct(Node $firstNode)
    {
        $this->firstNode = $firstNode;
    }

    /**
     * Rewinds the iterator back to the first node.
     *
     * @return void
     */
    public function rewind()
    {
        $this->currentNode = $this->firstNode;
        $this->height = 0;
    }

    /**
     * Checks if the current node position exists.
     *
     * @return bool
     * Indicates if the current node position exists.
     */
    public function valid()
    {
        return $this->currentNode !== null;
    }

    /**
     * Gets the current node.
     *
     * @return Node
     * The currently selected node.
     */
    public function current()
    {
        return $this->currentNode;
    }

    /**
     * Gets the height of the current node above the original node.
     *
     * @return int
     * The height of the current node above the original node.
     */
    public function key()
    {
        return $this->height;
    }

    /**
     * Moves to the parent node of the current node.
     *
     * @return void
     */
    public function next()
    {
        $this->currentNode = $this->currentNode->getParentNode();
        $this->height++;
    }
}
