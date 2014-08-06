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

namespace Switchbox\Tests\PropertyTree;

use Switchbox\PropertyTree\Node;
use Switchbox\PropertyTree\NodeList;

class NodeListTest extends \PHPUnit_Framework_TestCase
{
    protected $nodeList;

    public function setUp()
    {
        $this->nodeList = new NodeList();
    }

    public function testCount()
    {}

    /**
     * @depends testAddNode
     */
    public function testClearEmptiesList()
    {
        $this->nodeList->clear();
        $this->assertEmpty($this->nodeList);
    }

    public function testIsIteratable()
    {
        $c = iterator_count($this->nodeList);
    }
}
