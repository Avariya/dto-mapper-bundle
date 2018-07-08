<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class ChainStrategy implements StrategyInterface
{
    /**
     * @Annotation\Required()
     */
    public $sourceClass;

    /**
     * @Annotation\Required()
     * @var array<DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface>
     */
    public $list = [];

    /**
     * @return string
     */
    public function getSourceClass(): string
    {
        return $this->sourceClass;
    }

    /**
     * @return string[]
     */
    public function getList(): array
    {
        return $this->list;
    }
}
