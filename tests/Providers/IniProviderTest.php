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

namespace Switchbox\Tests\Providers;

use Switchbox\Providers\IniProvider;
use Switchbox\PropertyTree\Node;
use VirtualFileSystem\FileSystem;

class IniProviderTest extends \PHPUnit_Framework_TestCase
{
    public function configProvider()
    {
        $root = new Node();

        // simple keys/values
        $root->appendChild(new Node('name', 'awesome'));
        $root->appendChild(new Node('isAlive', true));
        $root->appendChild(new Node('age', 25));
        $root->appendChild(new Node('height', 167.64));

        // simple list
        $tags = $root->appendChild(new Node('tags'));
        $tags->appendChild(new Node(null, 'abc'));
        $tags->appendChild(new Node(null, 'def'));
        $tags->appendChild(new Node(null, 'ghi'));

        // simple map
        $paths = $root->appendChild(new Node('paths'));
        $paths->appendChild(new Node('root', '/'));
        $paths->appendChild(new Node('coolStuff', '/path/to/cool/stuff'));

        return array(array($root, __DIR__ . '/expected.ini'));
    }

    /**
     * @dataProvider configProvider
     */
    public function testLoad($expectedConfig, $expectedFile)
    {
        // create a provider
        $provider = new IniProvider($expectedFile);

        // load data from file
        $config = $provider->load();

        // loaded data should match original data
        $this->assertEquals($expectedConfig, $config);
    }
}
