<?php
namespace Switchbox\Tests\Providers;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use Switchbox\Providers\JsonProvider;

class JsonProviderTest extends PHPUnit_Framework_TestCase
{
    protected $fileSystem;
    protected $provider;

    public function setUp()
    {
        $this->fileSystem = vfsStream::setup('JsonProviderTest');
        $this->provider = new JsonProvider('vfs://JsonProviderTest/settings.json');
    }

    public function testFileIsLoaded()
    {
        // create virtual settings file
        $jsonFile = new vfsStreamFile('settings.json');
        $this->fileSystem->addChild($jsonFile);

        // write config data
        $jsonFile->write('{"foo":"bar"}');

        // load config file
        $config = $this->provider->load();

        // should contain 1 child
        $this->assertCount(1, $config);

        // get first child
        $fooNode = $config->getChildren()[0];

        // property name should be foo
        $this->assertEquals('foo', $fooNode->getName());

        // property should exist by name
        $this->assertInstanceOf('Switchbox\ConfigurationProperty', $config->getProperty('foo'));
    }
}
