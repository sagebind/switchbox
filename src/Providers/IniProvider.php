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
 * Loads and saves settings configuration from an INI file.
 */
class IniProvider extends AbstractFileProvider implements ProviderInterface
{
    /**
     * Loads settings configuration from the INI file.
     *
     * @return NodeList
     * The configuration contained in the file.
     */
    public function load()
    {
        // make sure the file is readable
        if (!is_readable($this->fileName))
        {
            throw new FileNotFoundException("The file '{$this->fileName}' is not readable.");
        }

        // load the ini keys into an array
        $array = parse_ini_file($this->fileName, true);

        // check for parse errors
        if ($array === false)
        {
            throw new \Exception("Syntax error in file '{$this->fileName}'.");
        }

        // return a config tree from the array
        return ArrayHelper::fromArray($array);
    }
}
