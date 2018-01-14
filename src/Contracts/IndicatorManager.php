<?php

namespace Laratrade\Indicators\Contracts;

use Closure;
use Illuminate\Support\Collection;

/**
 * @method int admi(Collection $ohlcv, int $timePeriod = 14)
 * @method int atr(Collection $ohlcv, int $timePeriod = 14)
 * @method int ao(Collection $ohlcv)
 * @method int bb(Collection $ohlcv, int $timePeriod = 10, float $nbDevUp = 2, float $nbDevDn = 2, int $mAType = 0)
 * @method int cmo(Collection $ohlcv, int $timePeriod = 14)
 * @method int cci(Collection $ohlcv, int $timePeriod = 14)
 * @method int htit(Collection $ohlcv, int $timePeriod = 4)
 * @method int hts(Collection $ohlcv, bool $trend = false)
 * @method int httvcm(Collection $ohlcv, bool $numPeriods = false)
 * @method int mmi(Collection $ohlcv, int $timePeriod = 200)
 * @method int mfi(Collection $ohlcv, int $timePeriod = 14)
 * @method int macd(Collection $ohlcv, int $timePeriod = 12, int $slowPeriod = 26, int $signalPeriod = 9)
 * @method int macdwcmat(Collection $ohlcv, int $fastTimePeriod = 12, int $fastMAType = 0, int $slowPeriod = 26, int $slowMAType = 0, int $signalPeriod = 9, int $signalMAType = 0)
 * @method int obv(Collection $ohlcv)
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
