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

/**
 * Base class for configuration that loads and saves to and from a file.
 */
abstract class AbstractFileProvider
{
    /**
     * The file path of the file containing configuration values.
     * @type string
     */
    protected $fileName;

    /**
     * Creates a new file provider with a given file name.
     *
     * @param string $fileName
     * The file path of the file containing configuration values.
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * Gets the file path of the file containing configuration values.
     *
     * @return string
     * The file path of the file containing configuration values.
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Sets the file path of the file containing configuration values.
     *
     * @param string $fileName
     * The new file path of the file containing configuration values.
     *
     * @return void
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }
}
