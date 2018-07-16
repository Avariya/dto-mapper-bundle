<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;

/**
 * Class MappedRelationsNodeDto
 * @DestinationClass
 * @SnakeCaseNamingStrategy(source="array")
 */
class MappedRelationsNodeDto
{
    public $propertyA;
    public $propertyB;
    public $propertyC;

    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedCollection(
     *      target="\Tests\DataFixtures\Dto\MappedRelationsNodeDto"
     *  )
     */
    public $nodeA;
}
