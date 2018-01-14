<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPoints;

class ChangeMomentumOscillatorIndicator implements Indicator
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
        $cmo = trader_cmo(
            $ohlcv->get('close'),
            $period
        );

        if (false === $cmo) {
            throw new NotEnoughDataPoints;
        }

        $cmoValue = array_pop($cmo);

        if ($cmoValue < -50) {
            return static::BUY;
        } elseif ($cmoValue > 50) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
