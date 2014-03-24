<?php
namespace Switchbox\Tests\Providers;

use PHPUnit_Framework_TestCase;

abstract class ProviderTestCase extends PHPUnit_Framework_TestCase
{
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
}
