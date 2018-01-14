<?php

namespace Laratrade\Indicators\Tests\Integration;

use Laratrade\Indicators\Contracts\IndicatorManager as IndicatorManagerContract;
use Laratrade\Indicators\IndicatorManager;

class IndicatorServiceProviderTest extends TestCase
{
    /** @test */
    public function it_registers_service_provider()
    {
        $this->assertTrue(
            $this->app->bound(IndicatorManagerContract::class)
        );

        $this->assertInstanceOf(
            IndicatorManager::class,
            $this->app->make(IndicatorManagerContract::class)
        );
    }
}
