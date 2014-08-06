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
 * Recursively iterates over an entire property tree.
 */
class RecursiveTreeIterator extends \RecursiveIteratorIterator
{
    /**
     * Creates a new recursive property tree iterator.
     *
     * @param Node $rootNode
     * The root node of the property tree to iterate over.
     */
    public function __construct(Node $rootNode)
    {
        $superList = new NodeList();
        $superList->addNode($rootNode);

        parent::__construct($superList->getIterator(), \RecursiveIteratorIterator::SELF_FIRST);
    }
}
