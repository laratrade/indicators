<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class HilbertTransformSinewaveIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'hts';

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
