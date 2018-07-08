<?php

namespace DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"CLASS","ANNOTATION"})
 */
class UnderscoreNamingStrategy implements NamingStrategyInterface
{
    /**
     * @Annotation\Required()
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
