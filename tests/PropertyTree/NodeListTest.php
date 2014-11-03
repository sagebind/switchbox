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

    public function testInitEmpty()
    {
        $this->assertEmpty($this->nodeList);
    }

    /**
     * @depends testInitEmpty
     */
    public function testAddNode()
    {
        $testNode = new Node('test');
        $this->nodeList->addNode($testNode);
        $this->assertContains($testNode, $this->nodeList);
    }

    /**
     * @depends testAddNode
     */
    public function testContains()
    {
        $this->nodeList = new NodeList();
        $testNode = new Node('test');
        $this->nodeList->addNode($testNode);
        $this->assertTrue($this->nodeList->contains($testNode));
    }

    /**
     * @depends testAddNode
     */
    public function testAddMultipleCount()
    {
        $expectedCount = 6;
        for ($i = 0; $i < $expectedCount; $i++)
        {
            $this->nodeList->addNode(new Node('test'));
        }

        $this->assertCount($expectedCount, $this->nodeList);

        return $this->nodeList;
    }

    /**
     * @depends testAddNode
     */
    public function testRemoveNode()
    {
        $testNode = new Node('test');
        $this->nodeList->addNode($testNode);
        $this->nodeList->removeNode($testNode);
        $this->assertNotContains($testNode, $this->nodeList);
    }

    /**
     * @depends testAddNode
     */
    public function testRemoveNodeByIndex()
    {
        $testNode = new Node('test');
        $this->nodeList->addNode($testNode);
        $this->nodeList->removeNodeByIndex(0);
        $this->assertNotContains($testNode, $this->nodeList);
    }

    /**
     * @depends testAddMultipleCount
     */
    public function testClearEmptiesList(NodeList $nodeList)
    {
        if ($nodeList->count() < 2)
        {
            $this->fail('Test requires a fixture containing at least 2 nodes.');
        }
        $nodeList->clear();
        $this->assertEmpty($nodeList);
    }
}
