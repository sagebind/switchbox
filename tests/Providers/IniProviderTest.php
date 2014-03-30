<?php
namespace Switchbox\Tests\Providers;

use Switchbox\ConfigurationProperty;
use Switchbox\Providers\IniProvider;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;

class IniProviderTest extends ProviderTestCase
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
    }

    /**
     * @dataProvider configDataProvider
     */
    public function testSave($data)
    {
        // create a provider
        $provider = new IniProvider('vfs://test/save.ini', true);

        // save provided data to provider
        $provider->save(ConfigurationProperty::fromArray(null, $data));
    }
}
