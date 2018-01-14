<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class MovingAverageCrossoverDivergenceWithControllableMovingAverageTypeIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'macdwcmat';

    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $fastTimePeriod
     * @param int        $fastMAType
     * @param int        $slowPeriod
     * @param int        $slowMAType
     * @param int        $signalPeriod
     * @param int        $signalMAType
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(
        Collection $ohlcv,
        int $fastTimePeriod = 12,
        int $fastMAType = 0,
        int $slowPeriod = 26,
        int $slowMAType = 0,
        int $signalPeriod = 9,
        int $signalMAType = 0
    ): int {
        $macdext = trader_macdext(
            $ohlcv->get('close'),
            $fastTimePeriod,
            $fastMAType,
            $slowPeriod,
            $slowMAType,
            $signalPeriod,
            $signalMAType
        );

        throw_unless($macdext, NotEnoughDataException::class);

        $macdValue = array_pop($macdext[0]) - array_pop($macdext[1]);

        if ($macdValue < 0) {
            return static::SELL;
        } elseif ($macdValue > 0) {
            return static::BUY;
        }

        return static::HOLD;
    }
}
