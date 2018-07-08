<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class ChainStrategy extends AbstractStrategy
{
    /**
     * @Required
     * @var array<DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface>
     */
    public $list = [];

    /**
     * @return StrategyInterface[]
     */
    public function getList(): array
    {
        return $this->list;
    }
}
