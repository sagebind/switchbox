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

use Switchbox\Providers\PhpScriptProvider;
use Switchbox\Tests\TestData;
use VirtualFileSystem\FileSystem;

class PhpScriptProviderTest extends AbstractProviderTestCase
{
    public function configProvider()
    {
        return array(array(TestData::getConfig(), TestData::getArray()));
    }

    /**
     * @dataProvider configProvider
     */
    public function testLoad($expectedConfig, $expectedArray)
    {
        // write data to a php script file
        $this->fs->createFile('/load.php', "<?php\nreturn ".var_export($expectedArray, true).';');

        // create a provider
        $provider = new PhpScriptProvider($this->fs->path('/load.php'));

        // load data from file
        $config = $provider->load($expectedConfig);

        // loaded data should match original data
        $this->assertEquals($expectedConfig, $config);
    }
}
