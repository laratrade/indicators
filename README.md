# Laratrade Indicators

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Laravel package for trading indicators.

## Requirements

Make sure all dependencies have been installed before moving on:

* [PHP](http://php.net/manual/en/install.php) >= 7.0
* [PECL Trader](http://php.net/manual/en/trader.installation.php)
* [Composer](https://getcomposer.org/download/)

## Install

Pull the package via Composer:

``` bash
$ composer require laratrade/indicators
```

## Usage

Via dependency injection

``` php
<?php

use Laratrade\Indicators\Contracts\IndicatorManager;

class MyClass
{
    /**
     * The indicator manager instance.
     *
     * @var IndicatorManager
     */
    protected $indicatorManager;

    /**
     * Create a new instance.
     *
     * @param IndicatorManager $indicatorManager
     */
    public function __construct(IndicatorManager $indicatorManager)
    {
        $this->indicatorManager = $indicatorManager;
    }
    
    /**
     * Handle my function.
     */
    public function myFunction()
    {
        ...
        $indicator = $this->indicatorManager->atr($ohlvc);
        ...
    }
}
```

Via facade

``` php
<?php

use Laratrade\Indicators\Facades\IndicatorManager;

class MyClass
{   
    /**
     * Handle my function.
     */
    public function myFunction()
    {
        ...
        $indicator = IndicatorManager::atr($ohlvc);
        ...
    }
}
```

## Indicators

- [`admi`](#admi)
- [`atr`](#atr)
- [`ao`](#ao)
- [`bb`](#bb)
- [`cmo`](#cmo)
- [`cci`](#cci)
- [`htit`](#htit)
- [`hts`](#hts)
- [`httvcm`](#httvcm)
- [`mmi`](#mmi)
- [`mfi`](#mfi)
- [`macd`](#macd)
- [`macdwcmat`](#macdwcmat)
- [`obv`](#obv)

### `admi`

Average directional movement index

```php
$indicator = IndicatorManager::admi($ohlvc);
```

### `atr`

Average true range

```php
$indicator = IndicatorManager::atr($ohlvc);
```

### `ao`

Awesome oscillator

```php
$indicator = IndicatorManager::ao($ohlvc);
```

### `bb`

Bollinger bands

```php
$indicator = IndicatorManager::bb($ohlvc);
```

### `cmo`

Change momentum oscillator

```php
$indicator = IndicatorManager::cmo($ohlvc);
```

### `cci`

Commodity channel index

```php
$indicator = IndicatorManager::cci($ohlvc);
```

### `htit`

Hilbert transform instantaneous trendline

```php
$indicator = IndicatorManager::htit($ohlvc);
```

### `hts`

Hilbert transform sinewave

```php
$indicator = IndicatorManager::hts($ohlvc);
```

### `httvcm`

Hilbert transform trend versus cycle mode

```php
$indicator = IndicatorManager::httvcm($ohlvc);
```

### `mmi`

Market meanness index

```php
$indicator = IndicatorManager::mmi($ohlvc);
```

### `mfi`

Money flow index

```php
$indicator = IndicatorManager::mfi($ohlvc);
```

### `macd`

Moving average crossover divergence

```php
$indicator = IndicatorManager::macd($ohlvc);
```

### `macdwcmat`

Moving average crossover divergence with controllable moving average type

```php
$indicator = IndicatorManager::macdwcmat($ohlvc);
```

### `obv`

On balance volume

```php
$indicator = IndicatorManager::obv($ohlvc);
```

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please use the issue tracker.

## Credits

- [Evgenii Nasyrov](https://github.com/nasyrov)
- [Patrick Teunissen](https://github.com/amavis442)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/laratrade/indicators.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laratrade/indicators/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laratrade/indicators.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laratrade/indicators.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/laratrade/indicators.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/laratrade/indicators
[link-travis]: https://travis-ci.org/laratrade/indicators
[link-scrutinizer]: https://scrutinizer-ci.com/g/laratrade/indicators/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laratrade/indicators
[link-downloads]: https://packagist.org/packages/laratrade/indicators
[link-contributors]: ../../contributors
