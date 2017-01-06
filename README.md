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

Register the Serviceprovider.

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
$apa = App::make(\Rootman\Simpleapa\SimpleAPA); // don't actually use it like that, better inject it

$apa->bestPrice('B004BM3M6W');
```

#### Sample helper file
```php
<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Rootman\Simpleapa\SimpleAPA;

/**
 * @param $asin
 * @return mixed
 */
function bestPrice($asin)
{
    return Cache::remember('asin_' . $asin, 60 * 24, function () use ($asin) {
        return App::make(SimpleAPA::class)->bestPrice($asin);
    });
}

/**
 * @param $price
 * @return string
 */
function formatPrice($price)
{
    return number_format($price, 2, ',', '.');
}

/**
 * @return string
 */
function getTag()
{
    return env('ASSOCIATE_TAG');
}

/**
 * @param $asin
 * @return string
 */
function amazonUrl($asin)
{
    return sprintf('http://www.amazon.de/dp/%s/?tag=%s', $asin, getTag());
}

/**
 * @param $asin
 * @return string
 */
function amazonRatingUrl($asin)
{
    return sprintf('http://www.amazon.de/product-reviews/%s/?tag=%s', $asin, getTag());
}
```
