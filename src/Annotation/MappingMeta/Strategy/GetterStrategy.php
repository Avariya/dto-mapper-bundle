<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class GetterStrategy implements StrategyInterface
{
    /**
     * @Annotation\Required()
     */
    public $sourceClass;

    /**
     * @Annotation\Required()
     */
    public $getterMethod;

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
    public function getGetterMethod(): string
    {
        return $this->getterMethod;
    }
}
