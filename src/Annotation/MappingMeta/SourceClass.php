<?php

namespace VKMapperBundle\Annotation\MappingMeta;

use Doctrine\Common\Annotations\Annotation;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface;

/**
 * Use this mapping to customize fields naming.
 *
 * @Annotation
 * @Annotation\Target("CLASS")
 */
class SourceClass
{
    /**
     * @var array<VKMapperBundle\Annotation\MappingMeta\NamingStrategy\AbstractNamingStrategy>
     */
    public $namingStrategies;

    /**
     * @return NamingStrategyInterface[]|null
     */
    public function getNamingStrategies(): ?array
    {
        return $this->namingStrategies;
    }
}
