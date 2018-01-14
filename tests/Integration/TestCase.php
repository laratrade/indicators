<?php

namespace Laratrade\Indicators\Tests\Integration;

use Laratrade\Indicators\IndicatorServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @inheritdoc
     */
    protected function getPackageProviders($app)
    {
        return [
            IndicatorServiceProvider::class,
        ];
    }
}
