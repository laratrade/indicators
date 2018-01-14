<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPointsException;

/**
 *
 * Moving Average Crossover Divergence (MACD) indicator as a buy/sell signal.
 * When the MACD signal less than 0, the price is trending down and it's time to sell.
 * When the MACD signal greater than 0, the price is trending up it's time to buy.
 *
 * Used to catch trends early and can also help us spot trend reversals.
 * It consists of 2 moving averages (1 fast, 1 slow) and vertical lines called a histogram,
 * which measures the distance between the 2 moving averages.
 * Contrary to what many people think, the moving average lines are NOT moving averages of the price.
 * They are moving averages of other moving averages.
 * MACD’s downfall is its lag because it uses so many moving averages.
 * One way to use MACD is to wait for the fast line to “cross over” or “cross under” the slow line and
 * enter the trade accordingly because it signals a new trend.
 */
class MovingAverageCrossoverDivergenceIndicator implements Indicator
{

    public function __invoke(Collection $ohlcv, int $period1 = 12, int $period2 = 26, int $period3 = 9): int
    {

        /*
         * Create the MACD signal and pass in the three parameters: fast period, slow period, and the signal.
         * we will want to tweak these periods later for now these are fine.
         * data, fast period, slow period, signal period (2-100000)
         * array $real [, integer $fastPeriod [, integer $slowPeriod [, integer $signalPeriod ]]]
         */

        $macd = trader_macd(
            $ohlcv->get('close'),
            $period1,
            $period2,
            $period3
        );

        if (false === $macd) {
            throw new NotEnoughDataPointsException('Not enough data points');
        }


        $macd_raw = $macd[0];
        $signal = $macd[1];

        //If not enough Elements for the Function to complete
        if (!$macd || !$macd_raw) {
            throw new NotEnoughDataPointsException('Not enough data points');
        }

        //$macd = $macd_raw[count($macd_raw)-1] - $signal[count($signal)-1];
        $macd = (array_pop($macd_raw) - array_pop($signal));

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
}
