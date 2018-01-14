<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;

/**
 * Average Directional Movement Index
 *
 *
 * @see http://www.investopedia.com/terms/a/adx.asp
 *
 * The ADX calculates the potential strength of a trend.
 * It fluctuates from 0 to 100, with readings below 20 indicating a weak trend and readings above 50 signaling a strong
 * trend. ADX can be used as confirmation whether the pair could possibly continue in its current trend or not. ADX can
 * also be used to determine when one should close a trade early. For instance, when ADX starts to slide below 50, it
 * indicates that the current trend is possibly losing steam.
 *
 * ADX Value    Trend Strength
 *      0-25    Absent or Weak Trend
 *     25-50    Strong Trend
 *     50-75    Very Strong Trend
 *     75-100    Extremely Strong Trend
 */
class AverageDirectionalMovementIndexIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $period
     *
     * @return int
     */
    public function __invoke(Collection $ohlcv, int $period = 14): int
    {
        $adx = trader_adx(
            $ohlcv->get('high'),
            $ohlcv->get('low'),
            $ohlcv->get('close'),
            $period
        );

        if (false === $adx) {
            throw new NotEnoughDataException;
        }

        $adx = array_pop($adx); //[count($adx) - 1];

        if ($adx > 50) {
            return static::BUY; // overbought
        } elseif ($adx < 20) {
            return static::SELL;  // underbought
        } else {
            return static::HOLD;
        }
    }
}
