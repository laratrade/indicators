<?php

namespace Laratrade\Indicators\Tests\Integration\Facades;

use Laratrade\Indicators\Facades\IndicatorManager as IndicatorManagerFacade;
use Laratrade\Indicators\IndicatorManager;
use Laratrade\Indicators\Tests\Integration\TestCase;

class IndicatorManagerTest extends TestCase
{
    /** @test */
    public function it_provides_service_facade()
    {
        $this->assertInstanceOf(
            IndicatorManager::class,
            IndicatorManagerFacade::getFacadeRoot()
        );
    }
}
