<?php

namespace DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"CLASS","ANNOTATION"})
 */
class IdentityNamingStrategy implements NamingStrategyInterface
{
    /**
     * @Annotation\Required()
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
