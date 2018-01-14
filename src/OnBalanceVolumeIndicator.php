<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPointsException;

/**
 * On Balance Volume
 *
 * @see http://stockcharts.com/school/doku.php?id=chart_school:technical_indicators:on_balance_volume_obv
 *
 * signal assumption that volume precedes price on confirmation, divergence and breakouts
 * use with mfi to confirm
 */
class OnBalanceVolumeIndicator implements Indicator
{

    public function __invoke(Collection $ohlcv, int $period = 14): int
    {

        $obv = trader_obv($ohlcv->get('close'), $ohlcv->get('volume'));

        if (false === $obv) {
            throw new NotEnoughDataPointsException('Not enough data points');
        }

        $current_obv = array_pop($obv);
        $prior_obv = array_pop($obv);
        $earlier_obv = array_pop($obv);

        /**
         *   This forecasts a trend in the last three periods
         *   TODO: this needs to be tested more, we might need to look closer for crypto currencies
         */
        if (($current_obv > $prior_obv) && ($prior_obv > $earlier_obv)) {
            return static::BUY; // upwards momentum
        } elseif (($current_obv < $prior_obv) && ($prior_obv < $earlier_obv)) {
            return static::SELL; // downwards momentum
        } else {
            return static::HOLD;
        }
    }
}
