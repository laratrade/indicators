<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

/**
 * Hilbert Transform - Sinewave (MESA indicator)
 *
 *
 * We are actually using DSP
 * on the prices to attempt to get a lag-free/low-lag indicator.
 * This indicator can be passed an extra parameter and it will tell you in
 * we are in a trend or not. (when used as an indicator do not use in a trending market)
 */
class HilbertTransformSinewaveIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param bool       $trend
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(Collection $ohlcv, bool $trend = false): int
    {
        $hts = trader_ht_sine(
            $ohlcv->get('open'),
            $ohlcv->get('close')
        );

        throw_unless($hts, NotEnoughDataException::class);

        $dcsine   = array_pop($hts[1]);
        $p_dcsine = array_pop($hts[1]);
        // leadsine is the first one it looks like.
        $leadsine   = array_pop($hts[0]);
        $p_leadsine = array_pop($hts[0]);

        if ($trend) {
            if ($dcsine < 0 && $p_dcsine < 0 && $leadsine < 0 && $p_leadsine < 0) {
                return static::BUY; // uptrend
            } elseif ($dcsine > 0 && $p_dcsine > 0 && $leadsine > 0 && $p_leadsine > 0) {
                return static::SELL; // downtrend
            }

            return static::HOLD;
        }

        /** WE ARE NOT ASKING FOR THE TREND, RETURN A SIGNAL */
        if ($leadsine > $dcsine && $p_leadsine <= $p_dcsine) {
            return static::BUY; // buy
        }
        if ($leadsine < $dcsine && $p_leadsine >= $p_dcsine) {
            return static::SELL; // sell
        }

        return static::HOLD;
    }
}
