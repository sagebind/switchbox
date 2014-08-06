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

    public function configProvider()
    {
        return array(array(TestData::getConfig()));
    }

    public function setUp()
    {
        $this->node = new Node();
    }

    public function testNameIsSet()
    {
        $this->node->setName('name');

        $this->assertEquals('name', $this->node->getName());
    }

    public function testAppendChildReturnsNodeAdded()
    {
        $nodeToAdd = new Node('foo', 'bar');
        
        $returnValue = $this->node->appendChild($nodeToAdd);

        $this->assertSame($nodeToAdd, $returnValue);
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
    public function testValue($value)
    {
        $this->node->setValue($value);
        $this->assertEquals($value, $this->node->getValue());
    }
}
