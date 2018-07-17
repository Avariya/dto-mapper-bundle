<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;

/**
 * Class MappedRelationsNodeDto
 * @DestinationClass
 */
class MappedRelationsNodeDto
{
    public $propertyA;
    public $propertyB;
    public $propertyC;

    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedCollection(
     *      target="Tests\DataFixtures\Dto\MappedRelationsNodeDto"
     *  )
     */
    public $nodeA;
}
