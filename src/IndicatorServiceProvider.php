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
        $this
            ->configure()
            ->offerPublishing()
            ->registerManager();
    }

    /**
     * Setup the configuration.
     *
     * @return $this
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/indicators.php',
            'indicators'
        );

        return $this;
    }

    /**
     * Setup the resource publishing group.
     *
     * @return $this
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/indicators.php' => config_path('indicators.php'),
            ], 'indicators');
        }

        return $this;
    }

    /**
     * Register the indicator manager.
     *
     * @return $this
     */
    protected function registerManager()
    {
        $this->app->singleton(IndicatorManagerContract::class, function () {
            return tap(new IndicatorManager, function ($manager) {
                $this->registerIndicators($manager);
            });
        });

        return $this;
    }

    /**
     * Register the indicators.
     *
     * @param IndicatorManagerContract $manager
     */
    protected function registerIndicators(IndicatorManagerContract $manager)
    {
        foreach (config('indicators') as $shortcut => $indicator) {
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
