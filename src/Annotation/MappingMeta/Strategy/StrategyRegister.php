<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class StrategyRegister
{
    /**
     * @Required
     * @var array<DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface>
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
