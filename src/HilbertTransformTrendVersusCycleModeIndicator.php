<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPointsException;

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

    public function __invoke(Collection $ohlcv, bool $numperiods = false)
    : int {

        $a_htm = trader_ht_trendmode($ohlcv->get('close'));

        if (false === $a_htm) {
            throw new NotEnoughDataPointsException('Not enough data points');
        }


        if (!$a_htm) {
            throw new \RuntimeException('Not enough data points. Maybe clear cache and start over.');
        }

        $htm = array_pop($a_htm);

        /**
         *  We can return the number of periods we have been
         *  in either a trend or a cycle by calling this again with
         *  $numperiods == true
         */
        if ($numperiods) {
            $nump = 1;

            for ($b = 0; $b < count($a_htm); $b++) {
                $test = array_pop($a_htm);
                if ($test == $htm) {
                    $nump++;
                } else {
                    break;
                }
            }

            return $nump;
        }

        /**
         *  Otherwise we just return if we are in a trend or not.
         */
        if ($htm == 1) {
            return 1; // we are in a trending mode
        }

        return 0; // we are cycling.
    }

}
