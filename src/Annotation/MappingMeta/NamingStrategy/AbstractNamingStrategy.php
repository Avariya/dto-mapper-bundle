<?php

namespace DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class AbstractNamingStrategy
 * @Annotation
 */
abstract class AbstractNamingStrategy implements NamingStrategyInterface
{
    /**
     * @Required
     * @var string
     */
    public $source;

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }
}
