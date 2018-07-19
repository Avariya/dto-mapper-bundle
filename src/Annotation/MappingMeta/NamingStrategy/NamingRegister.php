<?php

namespace VKMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class NamingRegister
{
    /**
     * @Required
     * @var array<VKMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface>
     */
    public $for = [];

    /**
     * @return array
     */
    public function getFor(): array
    {
        return $this->for;
    }
}
