<?php

namespace Tests\DataFixtures\Dto\ObjectToObject;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;

/**
 * Class DtoObjectToObject
 * @DestinationClass()
 */
class ArrayToDto
{
    /**
     * @var DtoNode
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\ObjectToObject\DtoNode")
     */
    public $nodeA;
}
