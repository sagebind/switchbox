# Switchbox
[![Latest Stable Version](https://poser.pugx.org/switchbox/switchbox/v/stable.png)](https://packagist.org/packages/switchbox/switchbox) [![Latest Unstable Version](https://poser.pugx.org/switchbox/switchbox/v/unstable.png)](https://packagist.org/packages/switchbox/switchbox) [![License](https://poser.pugx.org/switchbox/switchbox/license.png)](https://packagist.org/packages/switchbox/switchbox)

## Prolegomenon
You should never have to waste time in a project writing extra code just for loading configuration files. So stop twiddling around with [`parse_ini_file()`](http://php.net/parse_ini_file) and use Switchbox, a simple library meant to make dealing with configuration files in PHP quick and extensible.

Switchbox can both load and save configuration from any source using an extensible provider architecture. Potential providers include INI, JSON, YAML, XML, and Java-style property files, as well as databases, registries, and any other source you could think of. Providers currently implemented include JSON, YAML, and plain PHP files.

## Installation
The best way to install Switchbox is using [Composer](http://getcomposer.org). Just add Switchbox as a dependency to a project in your `composer.json` file:
```json
{
    "require": {
        "switchbox/switchbox": "dev-master"
    }
}
```

You can then install Switchbox using Composer:
```sh
$ composer install
```

Alternatively, you can add Switchbox as a dependency using the command line:
```sh
$ composer require switchbox/switchbox:dev-master
```

## Using Switchbox
The `Switchbox\Settings` class is used to manage a single configuration source. To create a `Settings` object, first create a provider object and pass it to the `Settings` constructor. The provider given will be used to load and save configuration data whenever `Settings::load()` or `Settings::save()` are called.

### A simplistic example
Below is an example of a very simple configuration file in [JSON](http://json.org):
```json
{
    "greeting": "Hello",
    "world": "Earth"
}
```

We can use the above config file with the following code:
```php
use Switchbox\Settings;
use Switchbox\Providers\JsonProvider;

// create a settings object
$settings = new Settings(
    new JsonProvider('settings.json')
);

// load config from provider
$settings->load();

// get the values of some properties
echo $settings->get('greeting').', '.$settings->get('world')."!\n";
```

## Running tests
You can run automated unit tests using [PHPUnit](http://phpunit.de) after installing dependencies:
```sh
$ vendor/bin/phpunit
```

## Where to get help
Need help? Just [send me an email](mailto:me@stephencoakley.com) with your questions. Be sure to add "Switchbox" to the message subject line so I know how I can help you out.

## Contributing
Want to help make Switchbox better? Simply fork this repo and start adding code. Switchbox's contribution model is very informal, so just submit a pull request. Pull requests will be reviewed and accepted if they fit the goal of the project and follow the contribution guidelines (available soon). Be sure to contact me if you have any questions.

## License
Switchbox is licensed under the Mozilla Public License 2.0 (MPL-2). See [LICENSE](LICENSE) for details.
