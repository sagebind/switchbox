# Switchbox
[![Latest Stable Version](http://img.shields.io/packagist/v/switchbox/switchbox.svg?style=flat)](https://packagist.org/packages/switchbox/switchbox)
[![License](http://img.shields.io/packagist/l/switchbox/switchbox.svg?style=flat)](http://www.apache.org/licenses/LICENSE-2.0)
[![Code Quality](http://img.shields.io/scrutinizer/g/coderstephen/switchbox.svg?style=flat)](http://scrutinizer-ci.com/g/coderstephen/switchbox)
[![Test Coverage](http://img.shields.io/scrutinizer/coverage/g/coderstephen/switchbox.svg?style=flat)](http://scrutinizer-ci.com/g/coderstephen/switchbox)

Configuration files are a pretty basic, prevalent part of creating software, but PHP doesn't offer a very good toolbox for using them. Switchbox is meant to be that toolbox, to allow developers to quickly and painlessly integrate configuration files into PHP applications.

Switchbox can both load and save configuration from *any source* using an extensible provider architecture. Potential providers include INI, JSON, YAML, XML, and Java-style property files, as well as databases, registries, and any other source you could think of. Providers currently implemented include JSON, YAML, and plain PHP files.

## Project status
Switchbox is currently in early development and is not yet production ready.

## Installation
The best way to install Switchbox is using [Composer](http://getcomposer.org). Just add Switchbox as a dependency to a project in your `composer.json` file:

```json
{
    "require": {
        "switchbox/switchbox": "0.1.*"
    }
}
```

You can then install Switchbox using Composer:

```sh
$ composer install
```

Alternatively, you can add Switchbox as a dependency using the command line:

```sh
$ composer require switchbox/switchbox:0.1.*
```

## Usage
The `Switchbox\Settings` class is used to manage a single configuration source. To create a `Settings` object, first create a provider object and pass it to the `Settings` constructor. The provider given will be used to load and save configuration data whenever `Settings::load()` or `Settings::save()` are called.

Below is an example of a very simple configuration file in [JSON](http://json.org):

```json
{
    "greeting": "Hello",
    "world": "Earth"
}
```

We can use the above settings file with the following code:

```php
use Switchbox\Settings;
use Switchbox\Providers\JsonProvider;

// create a settings object
$settings = new Settings(new JsonProvider('settings.json'));

// load config from provider
$settings->load();

// get the values of some properties
echo $settings->get('greeting').', '.$settings->get('world')."!\n";
```

The above code will display the following output:

```
Hello, Earth!
```

The same exact functionality could also be done using a [YAML](http://yaml.org) settings file:

```yaml
# settings.yaml
greeting: Hello
world: Earth
```

We only have to tweak our original code to use the `Switchbox\Providers\YamlProvider` to load the file. The rest works just fine:

```php
// ...
// create a settings object
$settings = new Settings(new YamlProvider('settings.yaml'));
// ...
```

Because the process of loading and saving configuration is decoupled from the `Settings` class, you can use any kind of source you want and use the same convenient API for all of them. All that is required is that the provider must implement the [`Switchbox\Providers\ProviderInterface`](src/Providers/ProviderInterface.php) interface, which just asks for `load()` and `save()` methods.

## Running tests
You can run automated unit tests using [PHPUnit](http://phpunit.de) after installing dependencies:

```sh
$ vendor/bin/phpunit
```

## Where to get help
Need help? Just [send me an email](mailto:me@stephencoakley.com) with your questions. Be sure to add "Switchbox" to the message subject line so I know how I can help you out.

## Contributing
Want to help make Switchbox something usable for the future? Fork this repo and start coding. Switchbox's contribution model is currently very informal, so just submit a pull request. Pull requests will be reviewed and accepted if they fit the goal of the project. Be sure to contact Stephen Coakley ([me@stephencoakley.com](mailto:me@stephencoakley.com)) if you have any questions.

## License
Switchbox is licensed under the Apache License, Version 2.0 (Apache-2.0). See [LICENSE.md](LICENSE.md) for details.

## Inspiration
Switchbox was inspired by the usability of the .NET Framework's settings API and the flexibility of Apache's [Commons Configuration](http://commons.apache.org/proper/commons-configuration/) library.
