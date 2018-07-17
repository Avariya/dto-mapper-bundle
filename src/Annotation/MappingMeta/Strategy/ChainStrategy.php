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
     * @var array<DTOMapperBundle\Annotation\MappingMeta\Strategy\ChainStrategyInterface>
     */
    public $list = [];

    /**
     * @return StrategyInterface[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return \DataMapper\Strategy\ChainStrategy::class;
    }
}
