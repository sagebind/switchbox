<?php
namespace Seffig;

class SettingsTest extends \PHPUnit_Framework_TestCase
{
    public function testAccess()
    {
        $settings = new Settings();

        $foo = "Hello World!";
        $settings->set('foo.bar', $foo);
        var_dump($settings);

        $this->assertEquals($foo, $settings->foo->bar->getValue());
    }
}
