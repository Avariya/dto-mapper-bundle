<?php

namespace VKMapperBundle\Annotation\MappingMeta\NamingStrategy;

/**
 * Interface NamingStrategyInterface
 */
interface NamingStrategyInterface
{
    /**
     * @return string|null
     */
    public function getSource(): ?string;

    /**
     * @return string
     */
    public function getStrategyClassName(): string;
}
