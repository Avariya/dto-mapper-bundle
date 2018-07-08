<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * @Required
     * @var string
     */
    public $source;

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }
}
