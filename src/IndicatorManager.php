<?php

namespace Laratrade\Indicators;

use Closure;
use Laratrade\Indicators\Contracts\Indicator;
use Laratrade\Indicators\Contracts\IndicatorManager as IndicatorManagerContract;
use Laratrade\Indicators\Exceptions\IndicatorNotFoundException;

class IndicatorManager implements IndicatorManagerContract
{
    /**
     * The indicators collection.
     *
     * @var array
     */
    protected $indicators = [];

    /**
     * Add an indicator resolver.
     *
     * @param string  $indicator
     * @param Closure $resolver
     */
    public function extend(string $indicator, Closure $resolver)
    {
        $this->indicators[$indicator] = $resolver;
    }

    /**
     * Resolve an indicator.
     *
     * @param string $indicator
     *
     * @return Indicator
     */
    public function resolve(string $indicator)
    {
        if (!isset($this->indicators[$indicator])) {
            throw new IndicatorNotFoundException;
        }

        return call_user_func($this->indicators[$indicator]);
    }

    /**
     * Dynamically handle the indicator calls.
     *
     * @param string $indicator
     * @param array  $parameters
     *
     * @return int
     */
    public function __call(string $indicator, array $parameters): int
    {
        return $this->resolve($indicator)($parameters[0]);
    }
}
