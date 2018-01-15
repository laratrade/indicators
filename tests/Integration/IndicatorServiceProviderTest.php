<?php

namespace Laratrade\Indicators\Tests\Integration;

use Illuminate\Support\ServiceProvider;
use Laratrade\Indicators\Contracts\IndicatorManager as IndicatorManagerContract;
use Laratrade\Indicators\IndicatorManager;
use Laratrade\Indicators\IndicatorServiceProvider;

class IndicatorServiceProviderTest extends TestCase
{
    /** @test */
    public function it_setups_configuration()
    {
        $this->assertEquals(
            include __DIR__ . '/../../config/indicators.php',
            $this->app->config->get('indicators')
        );
    }

    /** @test */
    public function it_offers_publishing()
    {
        $this->assertArrayHasKey(
            IndicatorServiceProvider::class,
            ServiceProvider::$publishes
        );

        $this->assertArrayHasKey(
            'indicators',
            ServiceProvider::$publishGroups
        );
    }

    /** @test */
    public function it_registers_manager()
    {
        $this->assertTrue(
            $this->app->bound(IndicatorManagerContract::class)
        );

        $this->assertInstanceOf(
            IndicatorManager::class,
            $this->app->make(IndicatorManagerContract::class)
        );
    }

    /** @test */
    public function it_registers_indicators()
    {
        $indicators = include __DIR__ . '/../../config/indicators.php';

        /** @var IndicatorManagerContract $manager */
        $manager = $this->app->make(IndicatorManagerContract::class);

        foreach ($indicators as $shortcut => $indicator) {
            $this->assertInstanceOf(
                $indicator,
                $manager->resolve($shortcut)
            );
        }
    }
}
