<?php

namespace VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
class NamingRegister
{
    /**
     * @Required
     * @var array<VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface>
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
