<?php

namespace Laratrade\Indicators;

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
        $high = $ohlcv->get('high');
        $low  = $ohlcv->get('low');

        $data = [];
        foreach ($high as $key => $value) {
            $data[$key] = ($high[$key] + $low[$key]) / 2;
        }

        $sma1 = trader_sma($data, 5);
        $sma2 = trader_sma($data, 34);

        array_pop($data); // take most recent off

        $sma3 = trader_sma($data, 5);
        $sma4 = trader_sma($data, 34);

        $last    = (array_pop($sma3) - array_pop($sma4));
        $current = (array_pop($sma1) - array_pop($sma2));

        if ($last <= 0 && $current > 0) {
            return static::BUY;
        } elseif ($last >= 0 && $current < 0) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
