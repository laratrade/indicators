<?php

namespace Laratrade\Indicators\Contracts;

use Illuminate\Support\Collection;

interface Indicator
{
    /**
     * The "buy" indicator.
     *
     * @var int
     */
    const BUY = 1;

    /**
     * The "sell" indicator.
     *
     * @var int
     */
    const SELL = -1;

    /**
     * The "hold" indicator.
     *
     * @var int
     */
    const HOLD = 0;

    /**
     * Invoke the indicator.
     *
     * @param Collection $ohlcv
     *
     * @return int
     */
    public function __invoke(Collection $ohlcv): int;
}
