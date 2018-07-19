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

        return $callback($value, $context);
    }
}
