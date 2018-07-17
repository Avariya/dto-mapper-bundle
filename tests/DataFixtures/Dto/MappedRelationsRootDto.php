<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;
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
     * @EmbeddedCollection(
     *      target="Tests\DataFixtures\Dto\MappedRelationsNodeDto"
     *  )
     */
    public $nodeA;

    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedCollection(
     *      target="Tests\DataFixtures\Dto\MappedRelationsNodeDto"
     *  )
     */
    public $nodeB;

    /**
     * @var MappedRelationsNodeInfo
     * @EmbeddedCollection(
     *      target="Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo",
     *      multi=true
     *  )
     */
    public $event = [];
}
