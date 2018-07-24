<?php

namespace VKMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"CLASS","ANNOTATION"})
 */
class MapNamingStrategy extends AbstractNamingStrategy
{
    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return \DataMapper\NamingStrategy\MapNamingStrategy::class;
    }
}
