<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY"})
 */
class StrategyRegister
{
    /**
     * @Annotation\Required()
     * @var array<DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface>
     */
    public $for = [];

    /**
     * @return NamingStrategyInterface[]
     */
    public function getFor(): array
    {
        return $this->for;
    }
}
