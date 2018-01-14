<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataException;
use Throwable;

class BollingerBandsIndicator implements Indicator
{
    /**
     * The shortcut name.
     *
     * @var string
     */
    const SHORTCUT = 'bb';

    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     * @param int        $timePeriod
     * @param float      $nbDevUp
     * @param float      $nbDevDn
     * @param int        $mAType
     *
     * @return int
     *
     * @throws Throwable
     */
    public function __invoke(
        Collection $ohlcv,
        int $timePeriod = 10,
        float $nbDevUp = 2,
        float $nbDevDn = 2,
        int $mAType = 0
    ): int {
        $close      = $ohlcv->get('close');
        $closeValue = array_pop($close);

        $bbands = trader_bbands(
            $ohlcv->get('close'),
            $timePeriod,
            $nbDevUp,
            $nbDevDn,
            $mAType
        );

        throw_unless($bbands, NotEnoughDataException::class);

        $upperValue = array_pop($bbands[0]);
        $lowerValue = array_pop($bbands[2]);

        if ($closeValue <= $lowerValue) {
            return static::BUY;
        } elseif ($closeValue >= $upperValue) {
            return static::SELL;
        }

        return static::HOLD;
    }
}
