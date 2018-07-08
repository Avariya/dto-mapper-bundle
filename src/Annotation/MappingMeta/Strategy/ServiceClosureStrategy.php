<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class ServiceClosureStrategy implements StrategyInterface
{
    /**
     * @Annotation\Required()
     */
    public $sourceClass;

    /**
     * @Annotation\Required()
     */
    public $closureProvider;

    /**
     * @Annotation\Required()
     */
    public $closureMethod;

    /**
     * @return string
     */
    public function getSourceClass(): string
    {
        return $this->sourceClass;
    }
}
