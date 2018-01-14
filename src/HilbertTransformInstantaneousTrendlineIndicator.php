<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class HilbertTransformInstantaneousTrendlineIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $period
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(Collection $ohlcv, int $period = 4): int
    {
        $htl = trader_ht_trendline($ohlcv->get('close'));

        throw_unless($htl, NotEnoughDataException::class);

        $wma = trader_wma($ohlcv->get('close'), $period);

        throw_unless($htl, NotEnoughDataException::class);

        $uptrend = $downtrend = $declared = 0;

        for ($i = 0; $i < 5; $i++) {
            $htlValue = array_pop($htl);
            $wmaValue = array_pop($wma);

            $uptrend   += ($wmaValue > $htlValue ? 1 : 0);
            $downtrend += ($wmaValue < $htlValue ? 1 : 0);

            $declared = (($wmaValue - $htlValue) / $htlValue);
        }

        if ($uptrend || $declared >= 0.15) {
            return static::BUY;
        } elseif ($downtrend || $declared <= 0.15) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
