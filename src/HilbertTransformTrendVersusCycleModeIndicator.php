<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class HilbertTransformTrendVersusCycleModeIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'httvcm';

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
