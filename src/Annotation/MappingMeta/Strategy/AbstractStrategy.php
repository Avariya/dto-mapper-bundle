<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

use DataMapper\Type\TypeDict;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    public $source;

    /**
     * @return string
     */
    public function getSource(): ?string
    {
        return $this->source;
    }
}
