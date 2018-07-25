<?php

namespace VKMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"ANNOTATION"})
 */
class IdentityNamingStrategy extends AbstractNamingStrategy
{
    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return \DataMapper\NamingStrategy\IdentityNamingStrategy::class;
    }
}
