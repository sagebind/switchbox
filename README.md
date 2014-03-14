# Switchbox
Switchbox is a simple library meant to make dealing with configuration files in PHP easy and extensible.

## Install
The best way to install switchbox is using [Composer](http://getcomposer.org):

```json
{
    "require": {
        "switchbox/switchbox": "dev-master"
    }
}
```

## Usage
Below is a simple example that loads settings from a [JSON](http://json.org) file.

```php
$settings = new Switchbox\Settings(new Switchbox\Providers\JsonProvider('settings.json'))->load();

echo $settings->get('world');
```

## Tests
```sh
phpunit
```

## License
Switchbox is licensed under the MIT license. See [LICENSE](LICENSE) for details.
