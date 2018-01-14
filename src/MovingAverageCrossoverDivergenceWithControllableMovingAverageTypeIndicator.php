<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;

/**
 * MACD indicator with controllable types and tweakable periods.
 *
 *
 * all periods are ranges of 2 to 100,000
 */
class MovingAverageCrossoverDivergenceWithControllableMovingAverageTypeIndicator implements Indicator
{
    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $fastPeriod
     * @param int        $fastMAType
     * @param int        $slowPeriod
     * @param int        $slowMAType
     * @param int        $signalPeriod
     * @param int        $signalMAType
     *
     * @return int
     */
    public function __invoke(
        Collection $ohlcv,
        int $fastPeriod = 12,
        int $fastMAType = 0,
        int $slowPeriod = 26,
        int $slowMAType = 0,
        int $signalPeriod = 9,
        int $signalMAType = 0
    ): int {

        // Create the MACD signal and pass in the three parameters: fast period, slow period, and the signal.
        // we will want to tweak these periods later for now these are fine.
        $macd = trader_macdext(
            $ohlcv->get('close'),
            $fastPeriod,
            $fastMAType,
            $slowPeriod,
            $slowMAType,
            $signalPeriod,
            $signalMAType
        );

        if (false === $macd) {
            throw new NotEnoughDataException;
        }

        if (!empty($macd)) {
            $macd = array_pop($macd[0]) - array_pop($macd[1]);
            // Close position for the pair when the MACD signal is negative
            if ($macd < 0) {
                return static::SELL;
                // Enter the position for the pair when the MACD signal is positive
            } elseif ($macd > 0) {
                return static::BUY;
            } else {
                return static::HOLD;
            }
        }

        return -2;
    }
}
