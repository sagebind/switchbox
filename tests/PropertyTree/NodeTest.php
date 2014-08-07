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

class NodeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->node = new Node();
    }

    public function valueProvider()
    {
        return array(
            array(null),
            array(true),
            array(false),
            array(0),
            array(42),
            array(-42),
            array(98.6),
            array('string'),
            array(array('a', 'b', 'c')),
            array(new \stdClass())
        );
    }

    public function testConstructorSetsName()
    {
        $node = new Node('name', 'value');
        $this->assertEquals('name', $node->getName());
    }

    public function testConstructorSetsValue()
    {
        $node = new Node('name', 'value');
        $this->assertEquals('value', $node->getValue());
    }

    public function testSetNameStoresName()
    {
        $this->node->setName('name');
        $this->assertEquals('name', $this->node->getName());
        return $this->node;
    }

    /**
     * @depends testSetNameStoresName
     */
    public function testSetNameAllowsNull($node)
    {
        $node->setName(null);
        $this->assertNull($node->getName());
    }

    /**
     * @expectedException \DomainException
     */
    public function testSetNameThrowsExceptionForNonString()
    {
        $this->node->setName(3);
    }

    /**
     * @dataProvider valueProvider
     */
    public function testSetValueStoresValue($value)
    {
        $this->node->setValue($value);
        $this->assertEquals($value, $this->node->getValue());
    }

    public function testHasChildNodesIsFalseWhenNodeIsEmpty()
    {
        $this->assertFalse($this->node->hasChildNodes());
    }

    public function testHasChildNodesIsTrueWhenNodeContainsChildren()
    {
        $this->node->appendChild(new Node());
        $this->assertTrue($this->node->hasChildNodes());
    }

    public function testParentNodeIsNullWhenRoot()
    {
        $this->assertNull($this->node->getParentNode());
    }

    public function testParentNodeIsNotNullWhenNotRoot()
    {
        $childNode = new Node();
        $this->node->appendChild($childNode);
        $this->assertInstanceOf('Switchbox\PropertyTree\Node', $childNode->getParentNode());
    }

    public function testAppendChildAddsNode()
    {
        $nodeToAdd = new Node('foo', 'bar');
        $this->node->appendChild($nodeToAdd);
        $this->assertContains($nodeToAdd, $this->node->getChildNodes());
    }

    public function testAppendChildReturnsNodeAdded()
    {
        $nodeToAdd = new Node('foo', 'bar');
        $returnValue = $this->node->appendChild($nodeToAdd);
        $this->assertSame($nodeToAdd, $returnValue);
    }

    public function testRemoveChildRemovesChild()
    {
        $node = new Node();

        $this->node->appendChild($node);
        $this->node->removeChild($node);

        $this->assertEmpty($this->node->getChildNodes());
    }

    /**
     * @depends testRemoveChildRemovesChild
     */
    public function testRemoveChildOnlyRemovesChildrenRemoved()
    {
        $nodes = array(new Node(), new Node(), new Node(), new Node());

        foreach ($nodes as $node)
        {
            $this->node->appendChild($node);
        }

        $this->node->removeChild($nodes[1]);
        $this->node->removeChild($nodes[3]);

        $this->assertContains($nodes[0], $this->node->getChildNodes());
        $this->assertNotContains($nodes[1], $this->node->getChildNodes());
        $this->assertContains($nodes[2], $this->node->getChildNodes());
        $this->assertNotContains($nodes[3], $this->node->getChildNodes());
    }
}
