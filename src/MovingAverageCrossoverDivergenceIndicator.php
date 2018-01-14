<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class MovingAverageCrossoverDivergenceIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'macd';

    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $timePeriod
     * @param int        $slowPeriod
     * @param int        $signalPeriod
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(Collection $ohlcv, int $timePeriod = 12, int $slowPeriod = 26, int $signalPeriod = 9): int
    {
        $macd = trader_macd(
            $ohlcv->get('close'),
            $timePeriod,
            $slowPeriod,
            $signalPeriod
        );

        throw_unless($macd, NotEnoughDataException::class);

        $macdValue = array_pop($macd[0]) - array_pop($macd[1]);

        if ($macdValue < 0) {
            return static::SELL;
        } elseif ($macdValue > 0) {
            return static::BUY;
        }

        return static::HOLD;
    }
}
