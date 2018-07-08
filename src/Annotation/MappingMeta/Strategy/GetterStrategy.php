<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class GetterStrategy extends AbstractStrategy
{
    /**
     * @Required
     * @var string
     */
    public $method;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
