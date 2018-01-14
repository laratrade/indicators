<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPointsException;

/**
 * Average True Range
 *
 * @see http://www.investopedia.com/articles/trading/08/atr.asp
 *
 * The idea is to use ATR to identify breakouts, if the price goes higher than
 * the previous close + ATR, a price breakout has occurred.
 *
 * The position is closed when the price goes 1 ATR below the previous close.
 *
 * This algorithm uses ATR as a momentum strategy, but the same signal can be used for
 * a reversion strategy, since ATR doesn't indicate the price direction (like adx below)
 */
class AverageTrueRangeIndicator implements Indicator
{

    public function __invoke(Collection $ohlcv, int $period = 14): int
    {

        if ($period > count($ohlcv->get('close'))) {
            $period = round(count($ohlcv->get('close')) / 2);
        }

        $data2 = $ohlcv;
        $current = array_pop($data2->get('close')); //[count($data['close']) - 1];    // we assume this is current
        $prev_close = array_pop($data2->get('close')); //[count($data['close']) - 2]; // prior close

        $atr = trader_atr(
            $ohlcv->get('high'),
            $ohlcv->get('low'),
            $ohlcv->get('close'),
            $period
        );

        if (false === $atr) {
            throw new NotEnoughDataPointsException;
        }


        $atr = array_pop($atr); // pick off the last

        // An upside breakout occurs when the price goes 1 ATR above the previous close
        $upside_signal = ($current - ($prev_close + $atr));

        // A downside breakout occurs when the previous close is 1 ATR above the price
        $downside_signal = ($prev_close - ($current + $atr));

        if ($upside_signal > 0) {
            return static::BUY;
        } elseif ($downside_signal > 0) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
