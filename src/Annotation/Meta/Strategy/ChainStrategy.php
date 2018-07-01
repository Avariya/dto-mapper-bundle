<?php

namespace MapperBundle\Mapping\Annotation\Meta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class ChainStrategy
{
    /**
     * @Required
     */
    public $sourceClass;

    /**
     * @Required
     * @var array
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
