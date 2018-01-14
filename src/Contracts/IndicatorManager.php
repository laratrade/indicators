<?php

namespace Laratrade\Indicators\Contracts;

use Closure;

/**
 * @method int ao(\Illuminate\Support\Collection $ohlcv)
 * @method int cmo(\Illuminate\Support\Collection $ohlcv, int $period = 14)
 */
interface IndicatorManager
{
    /**
     * Add an indicator resolver.
     *
     * @param string  $indicator
     * @param Closure $resolver
     */
    public function extend(string $indicator, Closure $resolver);

    /**
     * Resolve an indicator.
     *
     * @param string $indicator
     *
     * @return Indicator
     */
    public function resolve(string $indicator);
}
