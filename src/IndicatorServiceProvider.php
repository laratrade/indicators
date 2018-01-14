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
        foreach (['Ao', 'Cmo'] as $indicator) {
            $this->{"register{$indicator}Indicator"}($manager);
        }
    }

    /**
     * Register the awesome oscillator indicator.
     *
     * @param IndicatorManagerContract $manager
     */
    protected function registerAoIndicator(IndicatorManagerContract $manager)
    {
        $manager->extend('ao', function () {
            return new AwesomeOscillatorIndicator;
        });
    }

    /**
     * Register the change momentum oscillator indicator.
     *
     * @param IndicatorManagerContract $manager
     */
    protected function registerCmoIndicator(IndicatorManagerContract $manager)
    {
        $manager->extend('cmo', function () {
            return new ChangeMomentumOscillatorIndicator;
        });
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
