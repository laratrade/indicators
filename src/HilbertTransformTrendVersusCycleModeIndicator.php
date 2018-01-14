<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

/**
 * Hilbert Transform - Trend vs Cycle Mode
 *
 *
 * Simply tell us if the market is
 * either trending or cycling, with an additional parameter the method returns
 * the number of days we have been in a trend or a cycle.
 */
class HilbertTransformTrendVersusCycleModeIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param bool       $numPeriods
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(Collection $ohlcv, bool $numPeriods = false): int
    {
        $htm = trader_ht_trendmode(
            $ohlcv->get('open'),
            $ohlcv->get('close')
        );

        throw_unless($htm, NotEnoughDataException::class);

        $htmValue = array_pop($htm);

        /**
         *  We can return the number of periods we have been
         *  in either a trend or a cycle by calling this again with
         *  $numperiods == true
         */
        if ($numPeriods) {
            $nump = 1;

            for ($b = 0; $b < count($htm); $b++) {
                $test = array_pop($htm);
                if ($test == $htmValue) {
                    $nump++;
                } else {
                    break;
                }
            }

            return $nump;
        } elseif ($htmValue == 1) {
            return static::BUY;
        }

        return static::HOLD;
    }
}
