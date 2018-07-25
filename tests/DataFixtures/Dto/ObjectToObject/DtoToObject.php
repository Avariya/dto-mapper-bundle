<?php

namespace Tests\DataFixtures\Dto\ObjectToObject;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;

/**
 * Class DtoObjectToObjectNodeA
 * @DestinationClass
 */
class DtoToObject
{
    /**
     * @var ObjectNode
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\ObjectToObject\ObjectNode")
     */
    public $nodeA;
}
