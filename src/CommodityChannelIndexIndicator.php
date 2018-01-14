<?php
namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPointsException;


/**
 * Commodity Channel Index
 *
 * @see https://www.investopedia.com/terms/c/commoditychannelindex.asp?ad=dirN&qo=investopediaSiteSearch&qsrc=0&o=40186
 *
 * The Commodity Channel Index​ (CCI) is a momentum based technical trading tool used most often to help
 * determine when an investment vehicle is reaching a condition of being overbought or oversold.
 *
 */
class CommodityChannelIndexIndicator implements Indicator
{

    public function __invoke(Collection $ohlcv, int $period = 14): int
    {

        # array $high , array $low , array $close [, integer $timePeriod ]
        $cci = trader_cci($ohlcv->get('high'), $ohlcv->get('low'), $ohlcv->get('close'), $period);

        if (false === $cci) {
            throw new NotEnoughDataPointsException('Not enough data points');
        }

        $cci = array_pop($cci); #[count($cci) - 1];

        if ($cci > 100) {
            return static::SELL; // overbought
        } elseif ($cci < -100) {
            return static::BUY;  // underbought
        } else {
            return static::HOLD;
        }
    }

}
