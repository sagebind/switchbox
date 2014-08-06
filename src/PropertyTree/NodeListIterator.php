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
 * An iterator for looping over nodes contained in a node list.
 */
class NodeListIterator implements \RecursiveIterator, \SeekableIterator
{
    /**
     * @type NodeList
     */
    protected $nodeList;

    /**
     * @type int
     */
    protected $pointer = 0;

    /**
     * Creates a new iterator for a node list.
     *
     * @param NodeList $nodeList
     * The node list to iterate over.
     */
    public function __construct(NodeList $nodeList)
    {
        $this->nodeList = $nodeList;
    }

    /**
     * Rewinds the iterator back to the first node in the node list.
     *
     * @return void
     */
    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * Checks if the current node position exists.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->pointer < $this->nodeList->count();
    }

    /**
     * Gets the current node in the node list.
     *
     * @return Node
     */
    public function current()
    {
        return $this->nodeList->getNode($this->pointer);
    }

    /**
     * Gets the index of the current node in the node list.
     *
     * @return int
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * Moves forward to next node in the node list.
     *
     * @return void
     */
    public function next()
    {
        $this->pointer++;
    }

    /**
     * Seeks to a position in the node list.
     *
     * @param int $position
     * The position index to seek to.
     *
     * @return void
     *
     * @throws \OutOfRangeException
     * Thrown if a non-integer is passed for `$position` or if `$position` is less
     * than zero.
     *
     * @throws \OutOfBoundsException
     * Thrown if `$position` is outside the number of elements in the iterator.
     */
    public function seek($position)
    {
        if (!is_int($position) || $position < 0)
        {
            throw new \OutOfRangeException("Cannot seek to invalid position '{$position}'.");
        }

        if ($position >= $this->nodeList->count())
        {
            throw new \OutOfBoundsException("The position '{$position}' does not exist.");
        }

        $this->pointer = $position;
    }

    /**
     * Returns if an iterator can be created for the current node.
     *
     * @return bool
     * A boolean indicating if the current node has children.
     */
    public function hasChildren()
    {
        return $this->current()->hasChildNodes();
    }

    /**
     * Gets an iterator for the children of the current node.
     *
     * @return NodeListIterator
     * A new iterator for the children of the current node.
     */
    public function getChildren()
    {
        return $this->current()->getChildNodes()->getIterator();
    }
}
