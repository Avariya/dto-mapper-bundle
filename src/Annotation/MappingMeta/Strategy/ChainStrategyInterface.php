<?php

namespace VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

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
