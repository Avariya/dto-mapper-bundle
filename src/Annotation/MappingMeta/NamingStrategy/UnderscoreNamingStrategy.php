<?php

namespace VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"CLASS","ANNOTATION"})
 */
class UnderscoreNamingStrategy extends AbstractNamingStrategy
{
    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return \DataMapper\NamingStrategy\UnderscoreNamingStrategy::class;
    }
}
