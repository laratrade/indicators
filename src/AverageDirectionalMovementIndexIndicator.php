<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class AverageDirectionalMovementIndexIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'admi';

    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $timePeriod
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(Collection $ohlcv, int $timePeriod = 14): int
    {
        $adx = trader_adx(
            $ohlcv->get('high'),
            $ohlcv->get('low'),
            $ohlcv->get('close'),
            $timePeriod
        );

        throw_unless($adx, NotEnoughDataException::class);

        $adxValue = array_pop($adx);

        if ($adxValue > 50) {
            return static::BUY;
        } elseif ($adxValue < 20) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
