<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;

/**
 * Class DtoObjectToObject
 * @DestinationClass
 */
class DtoObjectToObject
{
    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedClass(target="Tests\DataFixtures\Model\Relations\DtoToObjectSourceConvertedProp")
     */
    public $nodeA;
}
