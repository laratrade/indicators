<?php

namespace Laratrade\Indicators\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;

class AwesomeOscillatorIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     *
     * @return int
     */
    public function __invoke(Collection $ohlcv): int
    {
        $highs = $ohlcv->get('high');
        $lows  = $ohlcv->get('low');

        $data = [];
        foreach ($highs as $key => $value) {
            $data[$key] = ($highs[$key] + $lows[$key]) / 2;
        }

        $sma1 = trader_sma($data, 5);
        $sma2 = trader_sma($data, 34);

        array_pop($data); // take most recent off

        $sma3 = trader_sma($data, 5);
        $sma4 = trader_sma($data, 34);

        $prior = (array_pop($sma3) - array_pop($sma4)); // last 'tick'
        $now   = (array_pop($sma1) - array_pop($sma2)); // current 'tick'

        if ($prior <= 0 && $now > 0) {
            return static::BUY;
        } elseif ($prior >= 0 && $now < 0) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
