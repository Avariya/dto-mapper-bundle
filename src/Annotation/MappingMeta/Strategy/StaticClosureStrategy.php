<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class StaticClosureStrategy implements StrategyInterface
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

    /**
     * @return string
     */
    public function getClosureProvider(): string
    {
        return $this->closureProvider;
    }

    /**
     * @return string
     */
    public function getClosureMethod(): string
    {
        return $this->closureMethod;
    }
}
