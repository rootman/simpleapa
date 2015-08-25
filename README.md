# SimpleAPA

A simple wrapper for https://github.com/Exeu/apai-io Amazon Product Advertising API.

## Installation

Add to composer.json:

```js
{
    "require": {
        "rootman/simpleapa": "~1.0"
    }
}
```

Fire up composer:

``` bash
$ composer install
```

### Laravel specific

Publish the config:

``` bash
$ php artisan vendor:publish
```

Fill the config.

## Usage

### Framework agnostic

```php
use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;

$conf = new GenericConfiguration();
$conf
    ->setCountry('de')
    ->setAccessKey('AMAZON ACCESS KEY')
    ->setSecretKey('AMAZON SECRET KEY')
    ->setAssociateTag('AMAZON ASSOCIATE TAG')
    ->setRequest('\ApaiIO\Request\Soap\Request')
    ->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

$apa = SimpleAPA(new ApaiIO($conf));

$apa->bestPrice('B004BM3M6W');
```

### Laravel

```php
$apa = App::make('SimpleAPA');

$apa->bestPrice('B004BM3M6W');
```