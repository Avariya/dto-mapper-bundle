<?php

namespace MapperBundle\Mapping\Annotation\Meta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class ClosureGetterStrategy extends Annotation
{
    /**
     * @Required
     */
    public $sourceClass;

    public $closureProvider;

    /**
     * @return string
     */
    public function getSourceClass(): string
    {
        return $this->sourceClass;
    }
}
