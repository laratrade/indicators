<?php

namespace Laratrade\Indicators;

use Illuminate\Support\ServiceProvider;
use Laratrade\Indicators\Contracts\IndicatorManager as IndicatorManagerContract;

class IndicatorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The indicator collection.
     *
     * @var array
     */
    protected $indicators = [
        AverageDirectionalMovementIndexIndicator::SHORTCUT                                   => AverageDirectionalMovementIndexIndicator::class,
        AverageTrueRangeIndicator::SHORTCUT                                                  => AverageTrueRangeIndicator::class,
        AwesomeOscillatorIndicator::SHORTCUT                                                 => AwesomeOscillatorIndicator::class,
        BollingerBandsIndicator::SHORTCUT                                                    => BollingerBandsIndicator::class,
        ChangeMomentumOscillatorIndicator::SHORTCUT                                          => ChangeMomentumOscillatorIndicator::class,
        CommodityChannelIndexIndicator::SHORTCUT                                             => CommodityChannelIndexIndicator::class,
        HilbertTransformInstantaneousTrendlineIndicator::SHORTCUT                            => HilbertTransformInstantaneousTrendlineIndicator::class,
        HilbertTransformSinewaveIndicator::SHORTCUT                                          => HilbertTransformSinewaveIndicator::class,
        HilbertTransformTrendVersusCycleModeIndicator::SHORTCUT                              => HilbertTransformTrendVersusCycleModeIndicator::class,
        MarketMeannessIndexIndicator::SHORTCUT                                               => MarketMeannessIndexIndicator::class,
        MoneyFlowIndexIndicator::SHORTCUT                                                    => MoneyFlowIndexIndicator::class,
        MovingAverageCrossoverDivergenceIndicator::SHORTCUT                                  => MovingAverageCrossoverDivergenceIndicator::class,
        MovingAverageCrossoverDivergenceWithControllableMovingAverageTypeIndicator::SHORTCUT => MovingAverageCrossoverDivergenceWithControllableMovingAverageTypeIndicator::class,
        OnBalanceVolumeIndicator::SHORTCUT                                                   => OnBalanceVolumeIndicator::class,
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(IndicatorManagerContract::class, function () {
            return tap(new IndicatorManager, function ($manager) {
                $this->registerIndicators($manager);
            });
        });
    }

    /**
     * Register the indicators on the manager.
     *
     * @param IndicatorManagerContract $manager
     */
    protected function registerIndicators(IndicatorManagerContract $manager)
    {
        foreach ($this->indicators as $shortcut => $indicator) {
            $manager->extend($shortcut, function () use ($indicator) {
                return new $indicator;
            });
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            IndicatorManagerContract::class,
        ];
    }
}
