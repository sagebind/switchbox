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

namespace Switchbox\Tests;

use Switchbox\Configuration;
use Switchbox\PropertyTree\Node;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = new Configuration();
        $this->config->getPropertyTree()->appendChild(new Node('foo', 'val'));
    }

    public function testGet()
    {
        $this->assertEquals('val', $this->config->get('foo'));
    }

    public function testAccess()
    {
        $this->config->getPropertyTree()->appendChild(new Node('bar'));

        $foo = 'Hello World!';
        $bar = 'Sup';

        $this->config->set('foo', $foo);
        $this->config->set('bar', $bar);

        $this->assertEquals($foo, $this->config->get('foo'));
        $this->assertEquals($bar, $this->config->get('bar'));

        $this->config->remove('foo');
        //$this->assertFalse($this->config->has('foo'));

        //$this->assertEquals('test', $this->config->get('foo.bar.baz.zap.fuz'));
    }

    public function testIterator()
    {
        $iterator = $this->config->getIterator(\RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $node)
        {
            //var_dump($node->getName());
        }
    }
}
