# Laravel 5 Biblia

## Installation

The Laravel 5 Biblia Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`jnplonte/biblia` package in your project's `composer.json`.

```json
{
    "require": {
        "jnplonte/biblia": "1.0.*"
    }
}
```

## Configuration

To use the Biblia Service Provider, you must register the provider when bootstrapping your Laravel application.

Find the `providers` key in your `config/app.php` and register the Service Provider.

```php
    'providers' => [
        // ...
        jnplonte\Biblia\BibliaServiceProvider::class,
    ],
```

Find the `aliases` key in your `config/app.php` and register the Facade.
```php
    'aliases' => [
        // ...
        'Biblia'    => jnplonte\Biblia\Facades\BibliaFacade::class,
    ],
```

## Usage

Run `php artisan vendor:publish` to publish the default config file, edit caching setting withing the resulting `config/biblia.php` file as desired.


```php
$bibliaS = Biblia::getVerse();
```
