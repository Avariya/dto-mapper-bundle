<?php

namespace DTOMapperBundle\Annotation\MappingAdapter;

use DataMapper\Strategy\StrategyInterface;

/**
 * Class StrategyAdapter
 */
class StrategyAdapter implements StrategyInterface
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
     * StrategyFactory constructor.
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
