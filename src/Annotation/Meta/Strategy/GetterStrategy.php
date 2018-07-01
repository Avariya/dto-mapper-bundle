<?php

namespace MapperBundle\Mapping\Annotation\Meta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class GetterStrategy extends Annotation
{
    /**
     * @Required
     */
    public $sourceClass;

    /**
     * @return string
     */
    public function getSourceClass(): string
    {
        return $this->sourceClass;
    }
}
