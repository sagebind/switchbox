<?php
namespace Switchbox\Tests\Providers;

use Switchbox\ConfigurationProperty;
use Switchbox\Providers\YamlProvider;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use Symfony\Component\Yaml\Yaml;

class YamlProviderTest extends ProviderTestCase
{
    public function setUp()
    {
        vfsStream::setup('test');
    }

    /**
     * @dataProvider configDataProvider
     */
    public function testLoad($data)
    {
        // write data to yaml file
        file_put_contents('vfs://test/load.yaml', Yaml::dump($data, 4));

        // create a provider
        $provider = new YamlProvider('vfs://test/load.yaml');

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
        $provider = new YamlProvider('vfs://test/save.yaml');

        // save provided data to provider
        $provider->save(ConfigurationProperty::fromArray(null, $data));
        
        // stored data should match original data
        $this->assertEquals(Yaml::dump($data, 4), file_get_contents('vfs://test/save.yaml'));
    }
}
