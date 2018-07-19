<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class StrategyRegister
{
    /**
     * @Required
     * @var array<VKMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface>
     */
    public $for = [];

    /**
     * @return StrategyInterface[]
     */
    public function getFor(): array
    {
        return $this->for;
    }
}
