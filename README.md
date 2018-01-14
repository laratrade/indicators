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
* [Composer](https://getcomposer.org/download/)

## Install

Pull the package via Composer:

``` bash
$ composer require laratrade/indicators
```

Register the service provider in `config/app.php`:

``` php
'providers' => [
    ...
    Laratrade\Indicators\IndicatorServiceProvider::class,
    ...
]
```

## Usage

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please use the issue tracker.

## Credits

- [Evgenii Nasyrov](https://github.com/nasyrov)
- [Patrick Teunissen](https://github.com/amavis442)

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
