<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;
use Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo;

/**
 * @DestinationClass
 * Class MappedRelationsRootDto
 * @SnakeCaseNamingStrategy(source="array")
 */
class MappedRelationsRootDto
{
    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\MappedRelationsNodeDto")
     */
    public $nodeA;

    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\MappedRelationsNodeDto")
     */
    public $nodeB;

    /**
     * @var MappedRelationsNodeInfo
     * @EmbeddedCollection(target="Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo")
     */
    public $event = [];
}
