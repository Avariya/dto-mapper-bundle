<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
    /**
     * @return string
     */
    public function getSource(): ?string;

    /**
     * @return string
     */
    public function getStrategyClassName(): string;
}
