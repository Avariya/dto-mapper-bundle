<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;

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
     * @var MappedRelationsNodeDto
     * @EmbeddedCollection(
     *      target="Tests\DataFixtures\Dto\MappedRelationsNodeInfoDto",
     *      multi=true
     *  )
     */
    public $event;
}
