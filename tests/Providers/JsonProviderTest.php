<?php
namespace Switchbox\Tests\Providers;

use Switchbox\ConfigurationProperty;
use Switchbox\Providers\JsonProvider;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;

class JsonProviderTest extends ProviderTestCase
{
    public function setUp()
    {
        // create a virtual filesystem
        vfsStream::setup('test');
    }

    /**
     * @dataProvider configDataProvider
     */
    public function testLoad($data)
    {
        // write data to json file
        file_put_contents('vfs://test/load.json', json_encode($data));

        // create a provider
        $provider = new JsonProvider('vfs://test/load.json');

        // load data from file
        $config = $provider->load();

        // loaded data should match original data
        $this->assertEquals($data, $config->toArray());
    }

    /**
     * @dataProvider configDataProvider
     */
    public function testSave($data)
    {
        // create a provider
        $provider = new JsonProvider('vfs://test/save.json');

        // save provided data to provider
        $provider->save(ConfigurationProperty::fromArray(null, $data));

        // stored data should match original data
        $this->assertJsonStringEqualsJsonString(json_encode($data), file_get_contents('vfs://test/save.json'));
    }
}
