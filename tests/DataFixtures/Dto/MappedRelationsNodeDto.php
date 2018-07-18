<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\EmbeddedClass;

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
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\MappedRelationsNodeDto")
     */
    public $nodeA;
}
