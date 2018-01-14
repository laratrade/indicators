<?php

namespace Laratrade\Indicators\Tests\Unit;

use Laratrade\Indicators\AwesomeOscillatorIndicator;
use Laratrade\Indicators\Exceptions\IndicatorNotFoundException;
use Laratrade\Indicators\IndicatorManager;

class IndicatorManagerTest extends TestCase
{
    /** @test */
    public function it_throws_exception_resolving_non_existing_indicator()
    {
        $this->expectException(IndicatorNotFoundException::class);

        $manager = new IndicatorManager;
        $manager->resolve('ao');
    }

    /** @test */
    public function it_resolves_existing_indicator()
    {
        $manager = new IndicatorManager;
        $manager->extend('ao', function () {
            return new AwesomeOscillatorIndicator;
        });

        $this->assertInstanceOf(
            AwesomeOscillatorIndicator::class,
            $manager->resolve('ao')
        );
    }
}
