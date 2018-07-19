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

        return $callback($value, $context);
    }
}
