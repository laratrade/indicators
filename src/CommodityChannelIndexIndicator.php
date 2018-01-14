<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class CommodityChannelIndexIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'cci';

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
        $cci = trader_cci(
            $ohlcv->get('high'),
            $ohlcv->get('low'),
            $ohlcv->get('close'),
            $timePeriod
        );

        throw_unless($cci, NotEnoughDataException::class);

        $cciValue = array_pop($cci);

        if ($cciValue < -100) {
            return static::BUY;
        } elseif ($cciValue > 100) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
