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

use Switchbox\Util;
use Switchbox\PropertyTree\Node;

/**
 * Loads settings configuration from a PHP script file.
 */
class PhpScriptProvider extends AbstractFileProvider implements ProviderInterface
{
    /**
     * Loads settings configuration from file.
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

        // parse the file
        $returnValue = include($this->fileName);

        // return value must be an array
        if (!is_array($returnValue))
        {
            throw new \UnexpectedValueException("The file '{$this->fileName}' does not return an array.");
        }

        // return a property tree from the returned array
        return Util::arrayToPropertyTree($returnValue);
    }
}
