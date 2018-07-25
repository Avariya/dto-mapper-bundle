<?php

namespace VKMapperBundle\Annotation\MappingMeta\NamingStrategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"ANNOTATION"})
 */
class MapNamingStrategy extends AbstractNamingStrategy
{
    /**
     * @Required
     * @var array<VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map>
     */
    public $convert = [];

    /**
     * @var array<VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map>
     */
    public $extract = [];

    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return \DataMapper\NamingStrategy\MapNamingStrategy::class;
    }

    /**
     * @return array
     */
    public function getConvert(): array
    {
        return $this->convert;
    }

    /**
     * @return array
     */
    public function getExtract(): array
    {
        return $this->extract;
    }
}
