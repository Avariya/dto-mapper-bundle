<?php

namespace Tests\DataFixtures\Dto;

use Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class ObjectToObjectDto
 * @DestinationClass
 */
class ObjectToObjectDto
{
    /**
     * @var MappedRelationsNodeInfo
     */
    private $nodeA;

    /**
     * @var MappedRelationsNodeInfo
     */
    private $nodeB;
}
