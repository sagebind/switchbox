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

namespace Switchbox\Providers;

use Switchbox\PropertyTree\ArrayHelper;
use Switchbox\PropertyTree\Node;

/**
 * Loads and saves settings configuration from a JSON file.
 */
class JsonProvider extends AbstractFileProvider implements SaveableProviderInterface
{
    /**
     * Loads settings configuration from the JSON file.
     *
     * @return Node
     * A property tree that represents the configuration contained in the file.
     */
    public function load()
    {
        // make sure the file is readable
        if (!is_readable($this->fileName))
        {
            throw new FileNotFoundException("The file '{$this->fileName}' is not readable.");
        }

        // load the json data from file
        $json = file_get_contents($this->fileName);

        // load the json object tree into an array
        $array = json_decode($json, true);

        // return a config tree from the array
        return ArrayHelper::fromArray($array);
    }

    /**
     * Saves settings configuration to the JSON file.
     *
     * @param Node $node
     * The root node of the configuration property tree to save.
     *
     * @return void
     */
    public function save(Node $node)
    {
        // turn the config tree into an array
        $array = ArrayHelper::toArray($node);

        // serialize the array to a json string
        $json = json_encode($array, JSON_PRETTY_PRINT);

        // write the json to file
        file_put_contents($this->fileName, $json);
    }
}
