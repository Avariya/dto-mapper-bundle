<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;
use DataMapper\Strategy\CollectionStrategy;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
class EmbeddedCollectionStrategy extends AbstractStrategy implements ChainStrategyInterface
{
    /**
     * @Required
     * @var string
     */
    public $target;

    /**
     * @var bool
     */
    public $multi;

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return bool
     */
    public function isMulti(): bool
    {
        return $this->multi;
    }

    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return CollectionStrategy::class;
    }
}
