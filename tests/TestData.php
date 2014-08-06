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

use Switchbox\PropertyTree\Node;

final class TestData
{
    public static function getConfig()
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

        // list of maps
        $authors = $root->appendChild(new Node('authors'));
        $authors->appendChild(new Node())
            ->appendChild(new Node('name', 'Leah'));
        $authors->appendChild(new Node())
            ->appendChild(new Node('name', 'Elsa'));

        return $root;
    }

    public static function getArray()
    {
        return array(
            'name' => 'awesome',
            'isAlive' => true,
            'age' => 25,
            'height' => 167.64,
            'tags' => array(
                'abc',
                'def',
                'ghi'
            ),
            'paths' => array(
                'root' => '/',
                'coolStuff' => '/path/to/cool/stuff'
            ),
            'authors' => array(
                array(
                    'name' => 'Leah'
                ),
                array(
                    'name' => 'Elsa'
                )
            )
        );
    }
}
