<?php

namespace VKMapperBundle\StrategyAdapter;

use DataMapper\Strategy\StrategyInterface;

/**
 * Class StaticClosureStrategyAdapter
 */
class StaticClosureStrategyAdapter implements StrategyInterface
{
    /**
     * @var string
     */
    private $serviceProvider;

    /**
     * @var string
     */
    private $getter;

    /**
     * ServiceClosureStrategyAdapter constructor.
     *
     * @param string $serviceProvider
     * @param string $getter
     */
    public function __construct(string $serviceProvider, string $getter)
    {
        $this->serviceProvider = $serviceProvider;
        $this->getter = $getter;
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($value, $context)
    {
        $callback = \call_user_func([$this->serviceProvider, $this->getter]);
        [$originSource, $sourceMappedPropertyName] = $context;

        // User experience improve, change default args order.
        // 1 source - origin data
        // 2 value - current value of source object mapped property
        return $callback($originSource, $value);
    }
}
