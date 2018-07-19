<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Interface ChainStrategyInterface
 */
interface ChainStrategyInterface
{
    /**
     * @return string
     */
    public function getStrategyClassName(): string;
}
