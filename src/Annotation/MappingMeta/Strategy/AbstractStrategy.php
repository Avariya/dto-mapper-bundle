<?php

namespace VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

use DataMapper\Type\TypeDict;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    public $source = TypeDict::ALL_TYPE;

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }
}
