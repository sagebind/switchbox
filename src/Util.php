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

namespace Switchbox;

/**
 * A static class of various utility functions.
 */
final class Util
{
    /**
     * Creates a property tree from a multidimensional array.
     *
     * @param array $array
     * The array containing the data to create a proeprty tree from.
     *
     * @return Node
     * The root node of a new property tree.
     */
    public static function arrayToPropertyTree(array $array)
    {
        $parentNode = new Node();

        // loop over the array
        foreach ($array as $key => $value)
        {
            // meta value item
            if ($key === '__value')
            {
                $parentNode->setValue($value);
                continue;
            }

            // item contains child items
            if (is_array($value))
            {
                $childNode = static::fromArray($value);
            }
            else
            {
                $childNode = new Node();
                $childNode->setValue($value);
            }

            // hash key means node has a name
            if (is_string($key))
            {
                $childNode->setName($key);
            }

            // add node to list
            $parentNode->appendChild($childNode);
        }

        // return the filled tree
        return $parentNode;
    }

    /**
     * Creates a multidimensional array from a property tree.
     *
     * @param Node $rootNode
     * The root node of the property tree.
     *
     * @return mixed
     * A multidimensional array that represents the data of the property tree.
     */
    public static function propertyTreeToArray(Node $rootNode)
    {
        if (!$rootNode->hasChildNodes())
        {
            return $rootNode->getValue();
        }

        $array = array();

        foreach ($rootNode->getChildNodes() as $childNode)
        {
            if ($childNode->getName() !== null)
            {
                $array[$childNode->getName()] = static::toArray($childNode);
            }
            else
            {
                $array[] = static::toArray($childNode);
            }
        }

        if ($rootNode->getValue() !== null)
        {
            $array['__value'] = $rootNode->getValue();
        }

        // return the array
        return $array;
    }
}
