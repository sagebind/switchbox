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

use Switchbox\Providers\YamlProvider;
use Switchbox\Tests\TestData;
use Symfony\Component\Yaml\Yaml;

class YamlProviderTest extends AbstractProviderTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->fs->createFile('/expected.yaml', Yaml::dump(TestData::getArray(), 4));
    }

    public function configProvider()
    {
        return array(array(TestData::getConfig()));
    }

    /**
     * @dataProvider configProvider
     */
    public function testLoad($expectedConfig)
    {
        // create an provider
        $provider = new YamlProvider($this->fs->path('/expected.yaml'));

        // load data from file
        $config = $provider->load();

        // loaded data should match original data
        $this->assertEquals($expectedConfig, $config);
    }

    /**
     * @dataProvider configProvider
     */
    public function testSave($expectedConfig)
    {
        // create an provider
        $provider = new YamlProvider($this->fs->path('/actual.yaml'));

        // save provided data to provider
        $provider->save($expectedConfig);

        // stored data should match original data
        $this->assertFileEquals($this->fs->path('/expected.yaml'), $this->fs->path('/actual.yaml'));
    }
}
