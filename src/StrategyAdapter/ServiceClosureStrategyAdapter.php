<?php

namespace VKMapperBundle\StrategyAdapter;

use DataMapper\Strategy\StrategyInterface;

/**
 * Class ServiceClosureStrategyAdapter
 */
class ServiceClosureStrategyAdapter implements StrategyInterface
{
    /**
     * @var object
     */
    private $serviceProvider;

    /**
     * @var string
     */
    private $getter;

    /**
     * StaticClosureStrategyAdapter constructor.
     *
     * @param object $serviceProvider
     * @param string $getter
     */
    public function __construct($serviceProvider, string $getter)
    {
        $this->serviceProvider = $serviceProvider;
        $this->getter = $getter;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($value, $context)
    {
        /** @var \Closure $callback */
        $callback = $this->serviceProvider->{$this->getter}();
        $callback->bindTo($this->serviceProvider);
        [$originSource, $sourceMappedPropertyName] = $context;

        // User experience improve, change default args order.
        // 1 source - origin data
        // 2 value - current value of source object mapped property
        return $callback($originSource, $value);
    }
}
