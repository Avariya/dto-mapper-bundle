<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;
use DataMapper\Strategy\CollectionStrategy;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class EmbeddedClassStrategy extends AbstractStrategy implements ChainStrategyInterface
{
    /**
     * @Required
     * @var string
     */
    public $target;

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return CollectionStrategy::class;
    }
}
