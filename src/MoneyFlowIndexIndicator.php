<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class MoneyFlowIndexIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'mfi';

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
        $mfi = trader_mfi(
            $ohlcv->get('high'),
            $ohlcv->get('low'),
            $ohlcv->get('close'),
            $ohlcv->get('volume'),
            $timePeriod
        );

        throw_unless($mfi, NotEnoughDataException::class);

        $mfiValue = array_pop($mfi);

        if ($mfiValue < -10) {
            return static::BUY;
        } elseif ($mfiValue > 80) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
