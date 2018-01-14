<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class OnBalanceVolumeIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(Collection $ohlcv): int
    {
        $obv = trader_obv(
            $ohlcv->get('close'),
            $ohlcv->get('volume')
        );

        throw_unless($obv, NotEnoughDataException::class);

        $currentValue = array_pop($obv);
        $priorValue   = array_pop($obv);
        $earlierValue = array_pop($obv);

        if (($currentValue > $priorValue) && ($priorValue > $earlierValue)) {
            return static::BUY;
        } elseif (($currentValue < $priorValue) && ($priorValue < $earlierValue)) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
