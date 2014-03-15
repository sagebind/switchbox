<?php
namespace Switchbox\Tests;

use Switchbox\Settings;
use Switchbox\Providers\JsonProvider;
use PHPUnit_Framework_TestCase;

class SettingsTest extends PHPUnit_Framework_TestCase
{
    public function testCreation()
    {
        return new Settings();
    }

    /**
     * @depends testCreation
     */
    public function testAccess(Settings $settings)
    {
        $foo = 'Hello World!';
        $bar = 'Sup';

        $settings->set('foo', $foo);
        $settings->set('bar', $bar);

        $this->assertEquals($foo, $settings->get('foo'));
        $this->assertEquals($bar, $settings->get('bar'));
    }
}
