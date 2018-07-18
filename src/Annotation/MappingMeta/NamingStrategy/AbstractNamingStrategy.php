<?php

namespace VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class AbstractNamingStrategy
 * @Annotation
 */
abstract class AbstractNamingStrategy implements NamingStrategyInterface
{
    public $source;

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }
}
