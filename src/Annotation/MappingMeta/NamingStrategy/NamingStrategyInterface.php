<?php

namespace DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

/**
 * Interface NamingStrategyInterface
 */
interface NamingStrategyInterface
{
    /**
     * @return string
     */
    public function getSource(): string;
}
