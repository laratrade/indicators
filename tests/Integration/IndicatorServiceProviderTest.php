<?php

namespace Laratrade\Indicators\Tests\Integration;

use Laratrade\Indicators\AwesomeOscillatorIndicator;
use Laratrade\Indicators\ChangeMomentumOscillatorIndicator;
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

    /** @test */
    public function it_register_awesome_oscillator_indicator()
    {
        /** @var IndicatorManagerContract $manager */
        $manager = $this->app->make(IndicatorManagerContract::class);

        $this->assertInstanceOf(
            AwesomeOscillatorIndicator::class,
            $manager->resolve('ao')
        );
    }

    /** @test */
    public function it_register_change_momentum_oscillator_indicator()
    {
        /** @var IndicatorManagerContract $manager */
        $manager = $this->app->make(IndicatorManagerContract::class);

        $this->assertInstanceOf(
            ChangeMomentumOscillatorIndicator::class,
            $manager->resolve('cmo')
        );
    }
}
