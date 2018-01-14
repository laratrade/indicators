<?php

namespace Laratrade\Indicators\Facades;

use Illuminate\Support\Facades\Facade;
use Laratrade\Indicators\Contracts\IndicatorManager as IndicatorManagerContract;

/**
 * @method static IndicatorManagerContract ao(\Illuminate\Support\Collection $ohlcv)
 * @method int IndicatorManagerContract cmo(\Illuminate\Support\Collection $ohlcv, int $period = 14)
 */
class IndicatorManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return IndicatorManagerContract::class;
    }
}
