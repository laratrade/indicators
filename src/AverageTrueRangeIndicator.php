<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class AverageTrueRangeIndicator implements Indicator
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
    public function __invoke(Collection $ohlcv, int $period = 14): int
    {
        $close      = $ohlcv->get('close');
        $closeCount = count($close);

        if ($period > $closeCount) {
            $period = round($closeCount / 2);
        }

        $atr = trader_atr(
            $ohlcv->get('high'),
            $ohlcv->get('low'),
            $ohlcv->get('close'),
            $period
        );

        throw_unless($atr, NotEnoughDataException::class);

        $currentValue  = array_pop($close);
        $previousValue = array_pop($close);
        $atrValue      = array_pop($atr);

        $upside   = ($currentValue - ($previousValue + $atrValue));
        $downside = ($previousValue - ($currentValue + $atrValue));

        if ($upside > 0) {
            return static::BUY;
        } elseif ($downside > 0) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
