<?php
namespace Switchbox\Tests\Providers;

use Switchbox\ConfigurationProperty;
use Switchbox\Providers\YamlProvider;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Yaml\Yaml;

class YamlProviderTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        vfsStream::setup('test');
    }

    public function configDataProvider()
    {
        // return example config data
        return array(
            // simple properties
            array(array(
                'firstName' => 'John',
                'lastName' => 'Smith',
                'isAlive' => true,
                'age' => 25,
                'height_cm' => 167.64
            )),

            // array of simple values
            array(array(
                'title' => 'awesome',
                'categories' => array(
                    'abc',
                    'def',
                    'ghi',
                    'jkl',
                    'mno',
                    'pqr',
                    'stu',
                    'vwx',
                    'yz'
                )
            )),

            // array of objects
            array(array(
                'NATO' => array(
                    'A' => 'Alpha',
                    'B' => 'Bravo',
                    'C' => 'Charlie',
                    'D' => 'Delta',
                    'E' => 'Echo',
                    'F' => 'Foxtrot',
                    'G' => 'Golf',
                    'H' => 'Hotel',
                    'I' => 'India',
                    'J' => 'Juliet',
                    'K' => 'Kilo',
                    'L' => 'Lima',
                    'M' => 'Mike',
                    'N' => 'November',
                    'O' => 'Oscar',
                    'P' => 'Papa',
                    'Q' => 'Quebec',
                    'R' => 'Romeo',
                    'S' => 'Sierra',
                    'T' => 'Tango',
                    'U' => 'Uniform',
                    'V' => 'Victor',
                    'W' => 'Whiskey',
                    'X' => 'X-ray',
                    'Y' => 'Yankee',
                    'Z' => 'Zulu'
                ),
                'Western' => array(
                    'A' => 'Adams',
                    'B' => 'Boston',
                    'C' => 'Chicago',
                    'D' => 'Denver',
                    'E' => 'Easy',
                    'F' => 'Frank',
                    'G' => 'George',
                    'H' => 'Henry',
                    'I' => 'Ida',
                    'J' => 'John',
                    'K' => 'King',
                    'L' => 'Lincoln',
                    'M' => 'Mary',
                    'N' => 'New York',
                    'O' => 'Ocean',
                    'P' => 'Peter',
                    'Q' => 'Queen',
                    'R' => 'Roger',
                    'S' => 'Sugar',
                    'T' => 'Thomas',
                    'U' => 'Union',
                    'V' => 'Victor',
                    'W' => 'William',
                    'X' => 'X-ray',
                    'Y' => 'Young',
                    'Z' => 'Zero'
                )
            )),

            // switchbox's composer.json file
            array(json_decode(file_get_contents(dirname(dirname(__DIR__)).'/composer.json'), true))
        );
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
