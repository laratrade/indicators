<?php

namespace Laratrade\Indicators;

use Illuminate\Support\Collection;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Exceptions\NotEnoughDataPointsException;


/**
 * Market Meanness Index (link) 
 *
 * This indicator is not a measure of how
 * grumpy the market is, it shows if we are currently in or out of a trend
 * based on price reverting to the mean.
 * 
 * NO TALib specific function
 * Market Meanness Index - tendency to revert to the mean
 * currently moving in our out of a trend?
 * prevent loss by false trend signals
 *
 * if mmi > 75 then not trending
 * if mmi < 75 then trending
 *
 */
class MarketMeannessIndexIndicator implements Indicator
{

    public function __invoke(Collection $ohlcv, int $period = 200): int
    {

        $data_close = [];
        foreach ($ohlcv->get('close') as $point) {
            $data_close[] = $point;
        }
        
        $nl     = $nh     = 0;
        $len    = count($data_close);
        $median = (array_sum($data_close) / $len);
        
        for ($a = 0; $a < $len; $a++) {
            if ($data_close[$a] > $median && $data_close[$a] > @$data_close[$a - 1]) {
                $nl++;
            } elseif ($data_close[$a] < $median && $data_close[$a] < @$data_close[$a - 1]) {
                $nh++;
            }
        }
        
        $mmi = 100. * ($nl + $nh) / ($len - 1);
        if ($mmi < 75) {
            return static::BUY;
        }
        
        if ($mmi > 75) {
            return static::SELL;
        }

        return static::HOLD;
    }

}
