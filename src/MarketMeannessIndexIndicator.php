<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;

class MarketMeannessIndexIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'mmi';

    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $timePeriod
     *
     * @return int
     */
    public function __invoke(Collection $ohlcv, int $timePeriod = 200): int
    {
        $close  = $ohlcv->get('close');
        $length = count($close);
        $median = array_sum($close) / $length;

        $nl = $nh = 0;

        for ($a = 0; $a < $length; $a++) {
            if ($close[$a] > $median && $close[$a] > @$close[$a - 1]) {
                $nl++;
            } elseif ($close[$a] < $median && $close[$a] < @$close[$a - 1]) {
                $nh++;
            }
        }

        $mmi = 100. * ($nl + $nh) / ($length - 1);

        if ($mmi < 75) {
            return static::BUY;
        } elseif ($mmi > 75) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
