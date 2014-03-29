<?php
namespace Switchbox\Tests\Providers;

use Switchbox\ConfigurationProperty;
use Switchbox\Providers\PhpProvider;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;

class PhpProviderTest extends ProviderTestCase
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
        // write data to a php script file
        file_put_contents('vfs://test/load.php', "<?php\nreturn ".var_export($data, true).';');

        // create a provider
        $provider = new PhpProvider('vfs://test/load.php');

        // load data from file
        $config = $provider->load();

        // loaded data should match original data
        $this->assertEquals($data, $config->toArray());
    }

    /**
     * @expectedException Switchbox\Providers\NotImplementedException
     */
    public function testSaveNotImplemented()
    {
        // create a provider
        $provider = new PhpProvider('vfs://test/save.php');

        // save to provider
        $provider->save(new ConfigurationProperty());
    }
}
