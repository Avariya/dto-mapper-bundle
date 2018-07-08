<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class CollectionStrategy implements StrategyInterface
{
    /**
     * @Annotation\Required()
     */
    public $targetClass;

    /**
     * @return string
     */
    public function getTargetClass(): string
    {
        return $this->targetClass;
    }
}
